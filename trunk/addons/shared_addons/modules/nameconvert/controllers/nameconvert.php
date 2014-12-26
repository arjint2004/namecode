<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a nameconvert module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Nameconvert Module
 */
class Nameconvert extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('nameconvert_m');
		$this->lang->load('nameconvert');
		$this->load->model('files/file_m');
		
		$this->template
			->append_css('module::nameconvert.css')
			->append_js('module::nameconvert.js');
	}

	/**
	 * All items
	 */
	public function process($token="",$actionx="")
	{
		//echo $token;
		//echo $actionx; 
		//echo md5("CreatedByAsbinArjinto12222014");
		
		if($token=="301048a7ace156bd32241ba0021b6c0d"){	
			if($actionx=="ExportExcell"){
				$this->export($_POST['id_group']);
				die();
			}
			if($actionx=="ExportExcellUnknown"){
				$this->exportunknown($_POST['id_group']);
				die();
			}
			if($actionx=="process"){
				$this->load->library('nameconvert/nameconverts');
				$this->import();
				$dataprocess=$this->nameconvert_m->get_nama();

				foreach($dataprocess as $dataresulr){
					//pr($dataresulr['name']);
					$result=$this->nameconverts->clear_name($dataresulr['name']);
					$conculsion=$this->conculsion2($result);
					$this->db->where('id',$dataresulr['id']);
					
					$data_update=array('result'=>serialize($result),'kesimpulan'=>$conculsion);
					
					if(strpos($conculsion, 'Unknown')===false){$data_update['has_unknown']=0;}else{$data_update['has_unknown']=1;}
					$this->db->update('nameconverts',$data_update);
					//echo $this->db->last_query();
				}
				unset($dataprocess);
				$this->autoexport();
			}
		}else{
			echo "Wrong Authentication";
		}
	}
	
	private function import()
	{
			$files=$this->db->query("SELECT a.id,a.name,a.filename FROM default_files a JOIN default_file_folders b ON a.folder_id=b.id WHERE b.name='import' LIMIT 1")->result_array();
			
			foreach($files as $datafiles){
				$id_groups=explode('.',$datafiles['name']);
				#$pathe="/home/studoid1/public_html/depan/uploads/default/files/".$datafiles['filename']."";
				$pathe="D:/webdevel/nameconverts/uploads/default/files/".$datafiles['filename']."";
				$data=$this->getdataexcellfile($pathe);
				
				unset($data['cells'][1]); 	 
				foreach($data['cells'] as $baris=>$dataimp){
					//pr($dataimp);die();
					$nameclear=$this->nameconverts->clearname($dataimp[1]);
					//pr($nameclear); 	die(); 
					//$UNIX_DATE = ($dataimp[3] - 25569) * 86400;
					//$born_date=gmdate("d-m-Y", $UNIX_DATE);
					$insert_data=array(
						'id_group'=>$id_groups[0],
						'name'=>str_replace("\x92","'",strtoupper($nameclear)),
						'born_place'=>$dataimp[2],
						'born_date'=>$dataimp[3],
						'religion'=>$dataimp[4],
						'last_education'=>$dataimp[5],
						'employment'=>$dataimp[6],
						'mother'=>strtoupper($dataimp[7]),
						'father'=>"".strtoupper($dataimp[8])."",
						'result'=>"",
						'kesimpulan'=>"",
						'active'=>1
					);
					//pr($insert_data);die();
					if($this->db->insert('nameconverts',$insert_data)){
						unset($insert_data);
					}
				}
				unset($data);
				$this->db->query("DELETE FROM default_files WHERE id='".$datafiles['id']."'");
				unlink($pathe);
			}
			unset($files);
	}
	private function getdataexcellfile($file=null){
			// Load the spreadsheet reader library
			$this->load->library('excel_reader');
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);
			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			return $data;
	 }
	public function autoexport()
	{
		$grup=$this->nameconvert_m->getAll_nameGroup("*",1);
		//pr($grup);
		foreach($grup as $dtgroup){
			$this->export($dtgroup['id'],1);
			$this->exportunknown($dtgroup['id'],1);
		}
	}	
	private function conculsion2($namaarray=array()){

		foreach($namaarray as $namaarray1){
			foreach($namaarray1 as $namaarray2){
				$merged[]=$namaarray2;
			}
		}
		
		$eval='';
		$i=-1;
		$resultnya='';
		$conculsion='';
		$merged=array_unique($merged);
		foreach($merged as $ix=>$result){
			$i++;
			$eval .='$merged[0]==$merged['.$i.'] AND ';
			$resultnya .=''.$result.' - ';
		}
		$eval=substr($eval,0,-5);
		$eval1='if('.$eval.'){
			$conculsion="Murni '.$merged[0].'";
		}else{
			$conculsion="'.substr($resultnya,0,-3).'";
		}';
		@eval($eval1);
		//pr(substr($eval,0,-5));
		//pr($eval);
		//pr($conculsion);
		//pr($merged);
		return $conculsion;
	}
	private function conculsion($namaarray=array()){

		foreach($namaarray as $namaarray1){
			foreach($namaarray1 as $namaarray2){
				$merged[]=$namaarray2;
			}
		}
		
		$eval='';
		$i=-1;
		$resultnya='';
		$conculsion='';
		foreach($merged as $ix=>$result){
			$i++;
			$eval .='$merged[0]==$merged['.$i.'] AND ';
			$resultnya .=''.$result.' ';
		}
		$eval=substr($eval,0,-5);
		$eval1='if('.$eval.'){
			$conculsion="Murni '.$merged[0].'";
		}else{
			$conculsion="Campuran '.$resultnya.'";
		}';
		@eval($eval1);
		//pr(substr($eval,0,-5));
		//pr($eval);
		//pr($conculsion);
		//pr($merged);
		return $conculsion;
	}
	//EXPORT
	function exportunknown($id_groups=0,$save=1){
		$rss='';
		$this->load->library('nameconvert/export');
		$namadata=$this->db->query('SELECT nm.*, g.group as region FROM default_nameconverts nm JOIN default_name_group g ON nm.id_group=g.id WHERE nm.id_group='.$id_groups.' AND nm.has_unknown=1 AND kesimpulan!="" AND result!=""')->result_array();
		//echo $this->db->last_query();
		foreach($namadata as $idd=>$datanama){
			$arrresult=unserialize($datanama['result']);
			foreach($arrresult as $nm=>$resdata){
				$rrq=implode(',',$resdata);
				$rss .=''.$nm.'='.$rrq.' |';
			}
			
			$namadata[$idd]['result']=$rss;
			$rss='';
		}
		//pr($namadata);
		
		if($save==1){
			$nmf=$this->export->processsave($namadata,@$namadata[0]['region'].'_UNKNOWN',$save);
			$this->insertfile(@$nmf,0);
		}else{
			$this->export->process($namadata,@$namadata[0]['region'].'_UNKNOWN',$save);
		}
		
	}
	private function insertfile($namafile="",$filesize=0){
				$this->db->query("DELETE FROM default_files WHERE name='".$namafile."'");
				$data = array(
					'id'			=> substr(md5(microtime() . $namafile), 0, 15),
					'folder_id'		=> 1,
					'user_id'		=> 1,
					'type'			=> "d",
					'name'			=> $namafile,
					'path'			=> '{{ url:site }}uploads/default/files/'.$namafile,
					'description'	=> '',
					'alt_attribute'	=> "undefined",
					'filename'		=> $namafile,
					'extension'		=> ".xlsx",
					'mimetype'		=> "application/zip",
					'filesize'		=> $filesize,
					'width'			=> 0,
					'height'		=> 0,
					'date_added'	=> now()
				);
				//$this->db->where('name',$namafile);
				if($namafile!=""){
					$this->db->insert('default_files',$data);
				}
	}
	function export($id_groups=0,$save=0){
		$rss='';
		$this->load->library('nameconvert/export');
		$namadata=$this->db->query('SELECT nm.*, g.group as region FROM default_nameconverts nm JOIN default_name_group g ON nm.id_group=g.id  WHERE nm.id_group='.$id_groups.' AND nm.has_unknown=0 AND kesimpulan!="" AND result!=""')->result_array();
		//echo $this->db->last_query();
		foreach($namadata as $idd=>$datanama){
			$arrresult=unserialize($datanama['result']);
			foreach($arrresult as $nm=>$resdata){
				$rrq=implode(',',$resdata);
				$rss .=''.$nm.'='.$rrq.' |';
			}
			
			$namadata[$idd]['result']=$rss;
			$rss='';
		}
		//pr($namadata);
		if($save==1){
			$nmf=$this->export->processsave($namadata,$namadata[0]['region'],$save);
			$this->insertfile($nmf,0);
		}else{
			$this->export->process($namadata,$namadata[0]['region'],$save);
		}
		
	}
	//STATISTIC
	public function index($offset = 0)
	{
		// set the pagination limit
		$limit = 5;
		
		$items = $this->nameconvert_m->limit($limit)
			->offset($offset)
			->get_all();
			
		// we'll do a quick check here so we can tell tags whether there is data or not
		$items_exist = count($items) > 0;

		// we're using the pagination helper to do the pagination for us. Params are: (module/method, total count, limit, uri segment)
		$pagination = create_pagination('nameconvert', $this->nameconvert_m->count_all(), $limit, 2);

		$this->template
			->title($this->module_details['name'], 'the rest of the page title')
			->set('items', $items)
			->set('items_exist', $items_exist)
			->set('pagination', $pagination)
			->build('index');
	}
}