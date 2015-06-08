<?php
class nameconverts{
	var $dataindikator;

	function __construct(){

		$qtitle=ci()->db->query('SELECT title FROM default_title')->result_array();
		$this->arrwilcarddb = array_map(function($var){ return $var['title']; }, $qtitle);	
		ci()->load->model('nameconvert_m');
		$this->dataindikator=ci()->nameconvert_m->getIndikatorforSearch();
		
	}
	function clear_name($string='MADYO SUTRISNO , NY .'){


		$strcleararray=explode(' ',$string);
		foreach($strcleararray as $dtstrcleararray){
			//$dtstrcleararray=$this->clearname($this->arrwilcarddb,$dtstrcleararray);
			if($dtstrcleararray!='' AND $dtstrcleararray!=' '){
				$outprocess=$this->process($dtstrcleararray);
				
				if(!empty($outprocess)){
					$res[$dtstrcleararray]=$outprocess;
				}else{
					$res[$dtstrcleararray][]='Unknown';
				}
				
			}
			
		}
		
		return $res;
		
	}
	function clearname($nama=''){
		$nameexpl=explode(' ',$nama);
		foreach($nameexpl as $idx=>$katanama){
			if(!in_array($katanama,$this->arrwilcarddb)){
				$outnama[]=$katanama;
			}
		}
		$outnama=@implode(' ',$outnama);
		
		
		$wilcard = '~ ! # $ % ^ & * ( ) _ +  - = \ ] [ | } { " : ; / . , ? > < ';
		$wilcard .=" ";
		$arrwilcardd=explode(" ",$wilcard);
		foreach($arrwilcardd as $wilc){
			$outnama=str_replace($wilc,'',$outnama);
		}
		
		return $outnama;
	}
	function process($matching_letters=''){
		//get indikator
		//ci()->load->model('nameconvert_m');
		//$dataindikator=ci()->nameconvert_m->getIndikatorforSearch();
		//pr($this->dataindikator);die();
		//$matching_letters = 'Mono';
		$out=array();
		//pr($matching_letters);
		
		foreach($this->dataindikator as $asal=>$datas){
			//$array2 = preg_grep("/{$matching_letters}/", $datas);
			//$array2 = in_array($matching_letters, $datas);
			if(in_array($matching_letters, $datas)){
			  $out[]=$asal;
				return $out;
				break 2;
			}
		}
		//pr($out);
		//die();
	}
}

?>