<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a nameconvert module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Nameconvert Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'Name Identifier';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('nameconvert_m');
		$this->load->library('form_validation');
		$this->lang->load('nameconvert');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|max_length[100]|required'
			)
		);

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js')
						->append_css('module::admin.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		// here we use MY_Model's get_all() method to fetch everything
		$items = $this->nameconvert_m->get_all();

		// Build the view with nameconvert/views/admin/items.php
		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/items');
	}

	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// See if the model can create the record
			if ($this->nameconvert_m->create($this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('nameconvert.success'));
				redirect('admin/nameconvert');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('nameconvert.error'));
				redirect('admin/nameconvert/create');
			}
		}
		
		$nameconvert = new stdClass;
		foreach ($this->item_validation_rules as $rule)
		{
			$nameconvert->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Build the view using nameconvert/views/admin/form.php
		$this->template
			->title($this->module_details['name'], lang('nameconvert.new_item'))
			->set('nameconvert', $nameconvert)
			->build('admin/form');
	}
	
	public function edit($id = 0)
	{
		$nameconvert = $this->nameconvert_m->get($id);

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);
			
			// See if the model can create the record
			if ($this->nameconvert_m->update($id, $this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('nameconvert.success'));
				redirect('admin/nameconvert');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('nameconvert.error'));
				redirect('admin/nameconvert/create');
			}
		}

		// Build the view using nameconvert/views/admin/form.php
		$this->template
			->title($this->module_details['name'], lang('nameconvert.edit'))
			->set('nameconvert', $nameconvert)
			->build('admin/form');
	}
	
	public function delete($id = 0)
	{
		// make sure the button was clicked and that there is an array of ids
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			// pass the ids and let MY_Model delete the items
			$this->nameconvert_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->nameconvert_m->delete($id);
		}
		redirect('admin/nameconvert');
	}
	
	
	
	
	
	private function getdataexcell($file=null){
		if($_FILES){
			// Load the spreadsheet reader library
			$this->load->library('excel_reader');
			// Set output Encoding.
			$this->excel_reader->setOutputEncoding('CP1251');
			$file =  $_FILES['file_excell']['tmp_name'] ;
			$this->excel_reader->read($file);
			error_reporting(E_ALL ^ E_NOTICE);
			// Sheet 1
			$data = $this->excel_reader->sheets[0] ;
			return $data;
		}
		return false;
	 }
	//CATEGORY IDENTIFIER
	
	public function identycategory()
	{
		
		if(!empty($_POST['idx'])){
			//pr($_POST);die();
			foreach($_POST['idx'] as $id){
				$this->db->query('DELETE FROM default_name_kategori_indikator WHERE id='.$id.'');
			}
		}
		//$this->load->model('nameconvert/nameconvert_m');
	
		$total_rows =$this->nameconvert_m->get_count_identifierCat();
		// Create pagination links
		$pagination = create_pagination('admin/nameconvert/identycategory', $total_rows,Settings::get('records_per_page'),4);

		$data = $this->nameconvert_m->get_identifierCat('*',array($pagination['limit'], $pagination['offset']),'');

		$this->input->is_ajax_request() and $this->template->set_layout(false);
		
		$this->template
			->title('Category Identifier')
			->set('data', $data)
			->set('pagination', $pagination)
			->build('admin/identycategory');
	}
	public function deleteidentycategory($id=0)
	{
		if(isset($id)){
			$this->db->where('id',$id);
			if($this->db->delete('name_kategori_indikator')){
				redirect('admin/nameconvert/identycategory');
				die();			
			}
		}
		
	}
	public function editidentycategory($id=0)
	{
		//$this->load->model('nameconvert/nameconvert_m');
		if(isset($_POST['id'])){
			$data_update=array(
						'kategori'=>$_POST['kategori'],
						'keterangan'=>$_POST['keterangan'],
						'active'=>$_POST['active']
			);
			$this->db->where('id',$id);
			if($this->db->update('name_kategori_indikator',$data_update)){
				redirect('admin/nameconvert/identycategory');
				die();
			}
		}
		$data=$this->nameconvert_m->get_identifierCatById($id);
		
		$this->template
			->title('Edit Category Identifier')
			->set('data', $data)
			->build('admin/newcategory');
	}
	public function newcategory()
	{
		if(isset($_POST['kategori'])){
			$data_insert=array('kategori'=>strtoupper($_POST['kategori']),'keterangan'=>$_POST['keterangan'],'active'=>1);
			if($this->db->insert('name_kategori_indikator',$data_insert)){
				redirect('admin/nameconvert/identycategory');
			}
		}
		
		$this->template
			->title($this->module_details['name'])
			->build('admin/newcategory');
	}
	public function activateidentycategory($id=0,$aktif=null)
	{
		if($aktif==0){
			$data_update=array('active'=>$aktif);
		}elseif($aktif==1){
			$data_update=array('active'=>$aktif);
		}
		//pr($data_update);
		$this->db->where('id',$id);
		if($this->db->update('name_kategori_indikator',$data_update)){
			redirect('admin/nameconvert/identycategory');
		}
	}
	public function importcategory()
	{
		if(isset($_FILES['file_excell'])){
			$data=$this->getdataexcell();
			unset($data['cells'][1]);
			//pr($data);die();
			foreach($data['cells'] as $baris=>$dataimp){
				$insert_data=array(
					'kategori'=>strtoupper($dataimp[1]),
					'keterangan'=>"$dataimp[2]",
					'active'=>$dataimp[3]
				);
				if($this->db->insert('name_kategori_indikator',$insert_data)){
					unset($insert_data);
				}
			}
			redirect('admin/nameconvert/identycategory');
		}
		
		$this->template
			->title($this->module_details['name'])
			->build('admin/importcategory');
	}
	
	//NAME GROUP
	
	public function identyname()
	{
		
		if(!empty($_POST['idx'])){
			//pr($_POST);die();
			foreach($_POST['idx'] as $id){
				$this->db->query('DELETE FROM default_indikator WHERE id='.$id.'');
			}
		}
		if(isset($_POST['id_kat_indikator']) && $_POST['id_kat_indikator']!=''){
			$cnd="AND id_kat_indikator=".$_POST['id_kat_indikator']."";
		}else{
			$cnd="";
		}
		//$this->load->model('nameconvert/nameconvert_m');
	
		$total_rows =$this->nameconvert_m->get_count_identifierName();
		// Create pagination links
		$pagination = create_pagination('admin/nameconvert/identyname', $total_rows,Settings::get('records_per_page'),4);

		$data = $this->nameconvert_m->get_identifierName('*',array($pagination['limit'], $pagination['offset']),$cnd);
		//pr($data);die();
		$this->input->is_ajax_request() and $this->template->set_layout(false);
		$identifirecat = $this->nameconvert_m->get_identifierCatAll("*",1);
		$this->template
			->title('Identifier Name')
			->set('data', $data)
			->set('pagination', $pagination)
			->set('identifirecat',$identifirecat)
			->build('admin/identyname');
	}
	
	public function newidentifier()
	{
		//$this->load->model('nameconvert/nameconvert_m');
		if(isset($_POST['nama'])){
			//pr($_POST);die();
			$this->load->library('nameconvert/nameconverts');
			foreach($_POST['nama'] as $idx=>$nama){
				if($nama!=''){
					$nameclear=$this->nameconverts->clearname(strtoupper($nama));
					$data_insert=array('nama'=>strtoupper($nameclear),'id_kat_indikator'=>$_POST['id_kat_indikator'],'active'=>1);
					$this->db->insert('indikator',$data_insert);
				}
			}
			redirect('admin/nameconvert/identyname');
		}
		$identifirecat = $this->nameconvert_m->get_identifierCatAll("*",1);
		$this->template
			->title('Add Identifier Name')
			->set('identifirecat',$identifirecat)
			->build('admin/newidentifier');
	}
	public function editidentyname($id=0)
	{
		//$this->load->model('nameconvert/nameconvert_m');
		if(isset($_POST['id'])){
			$data_update=array(
						'nama'=>$_POST['nama'],
						'id_kat_indikator'=>$_POST['id_kat_indikator'],
			);
			$this->db->where('id',$id);
			if($this->db->update('indikator',$data_update)){
				redirect('admin/nameconvert/identyname');
				die();
			}
		}
		$data=$this->nameconvert_m->get_identifierNameById($id);
		
		$identifirecat = $this->nameconvert_m->get_identifierCatAll("*",1);
		$this->template
			->title('Edit Category Identifier')
			->set('data', $data)
			->set('identifirecat',$identifirecat)
			->build('admin/nameidentform');
	}
	
	public function deleteidentyname($id=0)
	{
		if(isset($id)){
			$this->db->where('id',$id);
			if($this->db->delete('indikator')){
				redirect('admin/nameconvert/identyname');
				die();			
			}
		}
		
	}
	
	public function importidentifier()
	{
		if(isset($_FILES['file_excell'])){
			$data=$this->getdataexcell();
			unset($data['cells'][1]);
			$this->load->library('nameconvert/nameconverts');
			foreach($data['cells'] as $baris=>$dataimp){
				$nameclear=$this->nameconverts->clearname(strtoupper($dataimp[1]));
				$namaarray=explode(' ',$nameclear);
				//pr($namaarray);die();
				foreach($namaarray as $namamurni){
					if($namamurni!=''){
						$insert_data=array(
							'nama'=>strtoupper($namamurni),
							'id_kat_indikator'=>$_POST['id_kat_indikator'],
							'active'=>1
						);
						if($this->db->insert('indikator',$insert_data)){
							unset($insert_data);
						}				
					}				
				}

			}
			redirect('admin/nameconvert/identyname');
		}
		
		$identifirecat = $this->nameconvert_m->get_identifierCatAll("*",1);
		$this->template
			->title($this->module_details['name'])
			->set('identifirecat',$identifirecat)
			->build('admin/importidentifier');
	}
	//NAME GROUP
	public function namegroup()
	{	
		if(!empty($_POST['idx'])){
			//pr($_POST);die();
			foreach($_POST['idx'] as $id){
				$this->db->query('DELETE FROM default_name_kategori_indikator WHERE id='.$id.'');
			}
		}
		//$this->load->model('nameconvert/nameconvert_m');
	
		$total_rows =$this->nameconvert_m->get_count_nameGroup();
		// Create pagination links
		$pagination = create_pagination('admin/nameconvert/namegroup', $total_rows,Settings::get('records_per_page'),4);

		$data = $this->nameconvert_m->get_nameGroup('*',array($pagination['limit'], $pagination['offset']),'');

		$this->input->is_ajax_request() and $this->template->set_layout(false);
		
		$this->template
			->title('Category Identifier')
			->set('data', $data)
			->set('pagination', $pagination)
			->build('admin/namegroup');
	}
	
	public function newnamegroup()
	{
		if(isset($_POST['group'])){
			$data_insert=array('group'=>strtoupper($_POST['group']),'keterangan'=>$_POST['keterangan'],'nama'=>'','active'=>1);
			if($this->db->insert('name_group',$data_insert)){
				redirect('admin/nameconvert/namegroup');
			}
		}
		
		$this->template
			->title($this->module_details['name'])
			->build('admin/newnamegroup');
	}
	
	public function importnamegroup()
	{
		if(isset($_FILES['file_excell'])){
			$data=$this->getdataexcell();
			unset($data['cells'][1]);
			//pr($data);die();
			foreach($data['cells'] as $baris=>$dataimp){
				$insert_data=array(
					'group'=>strtoupper($dataimp[1]),
					'keterangan'=>$dataimp[2],
					'nama'=>'',
					'active'=>$dataimp[3]
				);
				if($this->db->insert('name_group',$insert_data)){
					unset($insert_data);
				}
			}
			redirect('admin/nameconvert/namegroup');
		}
		
		$this->template
			->title($this->module_details['name'])
			->build('admin/importnamegroup');
	}
	
	public function editnamegroup($id=0)
	{
		//$this->load->model('nameconvert/nameconvert_m');
		if(isset($_POST['id'])){
			$data_update=array(
						'group'=>$_POST['group'],
						'keterangan'=>$_POST['keterangan'],
						'active'=>$_POST['active']
			);
			$this->db->where('id',$id);
			if($this->db->update('name_group',$data_update)){
				redirect('admin/nameconvert/namegroup');
				die();
			}
		}
		$data=$this->nameconvert_m->get_nameGroupById($id);
		
		$this->template
			->title('Edit Name Group')
			->set('data', $data)
			->build('admin/newnamegroup');
	}
	
	
	public function deletenamegroup($id=0)
	{
		if(isset($id)){
			$this->db->where('id',$id);
			if($this->db->delete('name_group')){
				redirect('admin/nameconvert/namegroup');
				die();			
			}
		}
		
	}
	
	public function activatenamegroup($id=0,$aktif=null)
	{
		if($aktif==0){
			$data_update=array('active'=>$aktif);
		}elseif($aktif==1){
			$data_update=array('active'=>$aktif);
		}
		//pr($data_update);
		$this->db->where('id',$id);
		if($this->db->update('name_group',$data_update)){
			//echo $this->db->last_query();die();
			redirect('admin/nameconvert/namegroup');
		}
	}
	//NAME LIST

	public function process($id_group=0)
	{
		
		//$this->load->model('nameconvert/nameconvert_m');
		$this->load->library('nameconvert/nameconverts');
		
		$dataprocess=$this->nameconvert_m->get_namaByIdGroup($id_group);
		
		foreach($dataprocess as $dataresulr){
			$result=$this->nameconverts->clear_name($dataresulr['name']);
			$conculsion=$this->conculsion($result);
			$this->db->where('id',$dataresulr['id']);
			$data_update=array('result'=>serialize($result),'kesimpulan'=>$conculsion);
			$this->db->update('nameconverts',$data_update);
		}
		
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
	public function namelist()
	{
		if(isset($_POST['ExportExcell'])){
			$this->export($_POST['id_group']);
			die();
		}
		if(isset($_POST['process'])){
			$this->load->library('nameconvert/nameconverts');
			$dataprocess=$this->nameconvert_m->get_namaByIdGroup($_POST['id_group']);
			//pr($dataprocess);die();
			foreach($dataprocess as $dataresulr){
				$result=$this->nameconverts->clear_name($dataresulr['name']);
				$conculsion=$this->conculsion($result);
				$this->db->where('id',$dataresulr['id']);
				$data_update=array('result'=>serialize($result),'kesimpulan'=>$conculsion);
				
				$this->db->update('nameconverts',$data_update);
			}
		}
	
		if(!empty($_POST['idx'])){
			foreach($_POST['idx'] as $id){
				$this->db->query('DELETE FROM default_nameconverts WHERE id='.$id.'');
			}
		}
		$cnd='';
		if(isset($_POST['id_group']) && $_POST['id_group']!=''){$cnd='AND id_group='.$_POST['id_group'].'';}
		$total_rows =$this->nameconvert_m->get_count_name('',$cnd);
		// Create pagination links
		$pagination = create_pagination('admin/nameconvert/namelist', $total_rows,Settings::get('records_per_page'),4);

		$name = $this->nameconvert_m->get_name('*',array($pagination['limit'], $pagination['offset']),'',$cnd);

		$this->input->is_ajax_request() and $this->template->set_layout(false);
		
		$groupname = $this->nameconvert_m->get_nameGroupAll("*",1);
		
		$this->template
			->title('Name List')
			->set('name', $name)
			->set('groupname',$groupname)
			->set('pagination',$pagination)
			->build('admin/namelist');		
	}
	public function newname()
	{
		//$this->load->model('nameconvert/nameconvert_m');
		if(isset($_POST['name'])){
			$this->load->library('nameconvert/nameconverts');
			$nameclear=$this->nameconverts->clearname(strtoupper($_POST['name']));
			$mother=$this->nameconverts->clearname(strtoupper($_POST['mother']));
			$father=$this->nameconverts->clearname(strtoupper($_POST['father']));
			$data_insert=array(
								'id_group'=>$_POST['id_group'],
								'name'=>$nameclear,
								'born_place'=>$_POST['born_place'],
								'born_date'=>$_POST['born_date'],
								'religion'=>$_POST['religion'],
								'last_education'=>$_POST['last_education'],
								'employment'=>$_POST['employment'],
								'mother'=>$mother,
								'father'=>"".$father."",
								'result'=>"",
								'kesimpulan'=>"",
								'active'=>1
				);
			if($this->db->insert('nameconverts',$data_insert)){
				//echo $this->db->last_query();die();
				redirect('admin/nameconvert/namelist');
				die();
			}
		}
		$group =$this->nameconvert_m->getAll_nameGroup("*",1);
		$this->input->is_ajax_request() and $this->template->set_layout(false);
		$this->template
			->title('New Name')
			->set('group', $group)
			->build('admin/editnamelist');		
	}
	public function editnamelist($id=0)
	{
		//$this->load->model('nameconvert/nameconvert_m');
		if(isset($_POST['id'])){
			$data_update=array(
								'id_group'=>$_POST['id_group'],
								'name'=>$_POST['name'],
								'born_place'=>$_POST['born_place'],
								'born_date'=>$_POST['born_date'],
								'religion'=>$_POST['religion'],
								'last_education'=>$_POST['last_education'],
								'employment'=>$_POST['employment'],
								'mother'=>$_POST['mother'],
								'father'=>"".$_POST['father']."",
								'active'=>$_POST['active']
				);
			$this->db->where('id',$id);
			if($this->db->update('nameconverts',$data_update)){
				//echo $this->db->last_query();die();
				redirect('admin/nameconvert/namelist');
				die();
			}
		}
		$data=$this->nameconvert_m->get_nameById($id);
		$group =$this->nameconvert_m->getAll_nameGroup("*",1);
		$this->input->is_ajax_request() and $this->template->set_layout(false);
		$this->template
			->title('Edit Name')
			->set('data', $data)
			->set('group', $group)
			->build('admin/editnamelist');		
	}
	public function importname()
	{
		//$this->load->model('nameconvert/nameconvert_m');
		$this->load->library('nameconvert/nameconverts');
		
		$group =$this->nameconvert_m->getAll_nameGroup("*",1);
		if(isset($_FILES['file_excell'])){
			$data=$this->getdataexcell();
			unset($data['cells'][1]);	 	 	
				 	 	 
			foreach($data['cells'] as $baris=>$dataimp){
				$nameclear=$this->nameconverts->clearname($dataimp[1]);
				//pr($dataimp[1]); 	die(); 
				$UNIX_DATE = ($dataimp[3] - 25569) * 86400;
				$born_date=gmdate("d-m-Y", $UNIX_DATE);
				$insert_data=array(
					'id_group'=>$_POST['id_group'],
					'name'=>strtoupper($nameclear),
					'born_place'=>$dataimp[2],
					'born_date'=>$born_date,
					'religion'=>$dataimp[4],
					'last_education'=>$dataimp[5],
					'employment'=>$dataimp[6],
					'mother'=>strtoupper($dataimp[7]),
					'father'=>"".strtoupper($dataimp[8])."",
					'result'=>"",
					'kesimpulan'=>"",
					'active'=>1
				);
				//pr($insert_data);
				if($this->db->insert('nameconverts',$insert_data)){
					unset($insert_data);
				}
			}
			redirect('admin/nameconvert/namelist');
		}
		
		$this->template
			->title($this->module_details['name'])
			->set('group',$group)
			->build('admin/importname');	
	}	
	//IMPORT
	
	//EXPORT
	function export($id_groups=0){
		$rss='';
		$this->load->library('nameconvert/export');
		$namadata=$this->db->query('SELECT * FROM default_nameconverts WHERE id_group='.$id_groups.'')->result_array();
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
		$this->export->process($namadata);
	}
	//STATISTIC
	
	function test_clearname(){
		$this->load->library('nameconvert/nameconverts');
		$nameclear=$this->nameconverts->clearname('HJ. SISWO MULYO SUMARTO / WASIS');
		pr($nameclear);
	}
}
