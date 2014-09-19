<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Export
    {
		public function process($array)
        {
			//pr($array);die();
			switch(@$_POST['jenis']){
				case "Name_Convert":
					$header=array(
							array('Data','Name Research'),
					);
				break;
			}
					$header=array(
							array('Data','Name Research'),
					);
			/** Include PHPExcel */
			require_once 'PHPExcel.php';

			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel;
			if(!empty($array) && !empty($header)){
				$objPHPExcel->exports('pertemuan rpp',$array,'PertemuanPembelajaran',$header);
			}else{
				echo '<script>
				alert("Data kosong");
				//window.location="'.base_url().'akademik/mainakademik/index";
				window.close();
				</script>';
			}
		}
    }
?>