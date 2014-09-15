<?php
class nameconverts{
	
	function clear_name($string='MADYO SUTRISNO , NY .'){
		$wilcard = '~ ! # $ % ^ & * ( ) _ + ` - = \ ] [ | } { " : ; / . , ? > < ';
		$wilcard .=" '";
		$arrwilcard=explode(" ",$wilcard);
		
		foreach($arrwilcard as $wilc){
			$string=str_replace($wilc,'',$string);
		}
		$strcleararray=explode(' ',$string);
		foreach($strcleararray as $dtstrcleararray){
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
	
	function process($matching_letters=''){
		//get indikator
		ci()->load->model('nameconvert_m');
		$dataindikator=ci()->nameconvert_m->getIndikatorforSearch();
		//pr($dataindikator);
		//$matching_letters = 'Mono';
		$out=array();
		foreach($dataindikator as $asal=>$datas){
			$array2 = preg_grep("/{$matching_letters}/", $datas);
			if(!empty($array2)){
			  $out[]=$asal;
			}
		}
		return $out;
	}
}

?>