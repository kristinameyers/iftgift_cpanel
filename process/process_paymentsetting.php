<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once ('../inc/functii.php');
unset($_SESSION['payment_setting_err']);
//print_r($_REQUEST); exit;
if (isset($_POST['payment_setting'])){ 

     	unset($_SESSION['payment_setting_err']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['payment_setting'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////cat_name valcatidation////////	
	if($setting==''){
		$_SESSION['payment_setting_err']['setting'] = 'Please select payment option';
		$flgs = true;
	
	}
	 
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=payment_setting'); exit;
		
  }else{
   		$insQry ="update ".tbl_payment_setting." set payment_option ='".$setting."' where settingID = '1'";
  		mysql_query($insQry)or die (mysql_error());		
		unset($_SESSION['payment_setting_err']);
		unset($_SESSION['payment_setting']);
		$_SESSION['payment_setting_err']['payment'] = 'Payment option update successfully!';
		header('location:'.ruadmin.'home.php?p=payment_setting'); exit;
  }
  
}
?>