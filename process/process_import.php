<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once ('../inc/functii.php');
include ("../inc/upload.php");

unset($_SESSION['import_err']);
unset($_SESSION['import']);
//echo "<pre>";
//print_r($_FILES); exit;

if (isset($_POST['Importer'])){ 

     	unset($_SESSION['import_err']);
	    unset($_SESSION['import']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['import'][$k]=$v;
	}
  	$flgs = false;

	
	$file_names = $_FILES['uploadedfile']['name'];
	$ext = pathinfo($file_names, PATHINFO_EXTENSION);
		$fsize = $_FILES['uploadedfile']['size']; 
		if($file_names==''){
			$_SESSION['import_err']['file_names'] = "Please Select a CSV File to Import";
			$flgs = true;
		}
		else if(strtolower($ext) == "csv" && $fsize<='1048576'){  
			 ini_set("auto_detect_line_endings", true);
			 $filename = $_FILES['uploadedfile']['tmp_name'];
			 $handle = fopen($filename, "r");
			 $data = fgetcsv($handle);
		   	//echo '<pre>';print_r($data);exit;
			 $count = 0 ;
			 $data_arr = array();
			 $time = $_SESSION['uploade_time']  = time();	 
			 $fname	=	$file_names;
			 $i = 0;
			while (!feof($handle)) {
			//echo "<pre>";print_r($handle);exit;
				$csv_data[] = fgets($handle, 1024);
				$csv_array = explode(",", $csv_data[$i]);
				$insert_csv = array();
				$insert_csv['image_code'] = $csv_array[0];
				$insert_csv['vendor'] = $csv_array[1];
				$insert_csv['pro_name'] = $csv_array[2];
				$insert_csv['price'] = $csv_array[3];
				$insert_csvs= explode(':',$csv_array[4]);
				$insert_csv['category'] = $insert_csvs[0];
				$insert_csv['sub_category'] = trim($insert_csvs[1]);
				$insert_csv['gender'] = $csv_array[5];
				//echo '<pre>';print_r($insert_csv['gender']);exit;
				$query = "INSERT INTO ".tbl_product." SET image_code='".$insert_csv['image_code']."',vendor='".$insert_csv['vendor']."',pro_name='".$insert_csv['pro_name']."',price='".$insert_csv['price']."',category='".$insert_csv['category']."',sub_category='".$insert_csv['sub_category']."',gender='".$insert_csv['gender']."'";
				$n=mysql_query($query);
				$i++;
			}
				
		}else{ 
			$_SESSION['import_err']['file_names'] = "File is not in csv format or size exceed from 1 MB";
			$flgs = true;
		}	
	
	
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=importer'); exit;
		
  }
  
}

?>