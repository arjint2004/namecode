<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export
    {
		public function process($array,$namefile='export',$save=0)
        {
			//pr($save);die();
			switch(@$_POST['jenis']){
				case "Name_Convert":
					$header=array(
							array('Data','Name Research'),
					);
				break;
			}
					$header=array(
							array('','')
					);
			/** Include PHPExcel */
			require_once 'PHPExcel.php';

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel;
			if(!empty($array) && !empty($header)){
				$objPHPExcel->exports('default',$array,$namefile,$header,$save);
				
			}else{
				echo '<script>
				alert("Data kosong");
				//window.location="'.base_url().'akademik/mainakademik/index";
				window.close();
				</script>';
			}
		}
		public function processsave($array,$namefile='export',$save=0)
        {
			//pr($save);die();
			switch(@$_POST['jenis']){
				case "Name_Convert":
					$header=array(
							array('Data','Name Research'),
					);
				break;
			}
					$header=array(
							array('','')
					);
			/** Include PHPExcel */
			require_once 'PHPExcel.php';

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel;
			if(!empty($array) && !empty($header)){
				$nmf=$objPHPExcel->exports('default',$array,$namefile,$header,$save);
				return $nmf;
			}else{
				/*echo '<script>
				alert("Data kosong");
				//window.location="'.base_url().'akademik/mainakademik/index";
				window.close();
				</script>';*/
			}
		}
    }
?>