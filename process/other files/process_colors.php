<?php 
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');

unset($_SESSION['biz_color_err']);
unset($_SESSION['biz_color']);
//print_r($_REQUEST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$Id  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from color where Id  = $Id ");
	
		$_SESSION['biz_color_err']['colors'] = 'Color deleted !';
		header('location:'.ruadmin.'home.php?p=colors'); exit;			
	
	} 


if (isset($_POST['Savecolor'])){ 

     	unset($_SESSION['biz_color_err']);
	    unset($_SESSION['biz_color']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['biz_color'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_color_err']['name'] = 'Please enter color name';
		$flgs = true;
	
	}
	
	if($code==''){
		$_SESSION['biz_color_err']['code'] = 'Please enter color code';
		$flgs = true;
	
	}
	 
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=colors'); exit;
		
  }else{

   			$insQry ="insert into color set name ='$name',
									code_name = '$code_name',
									ref_code = '$ref_code',
									code = '$code',
									price = '$price',
									dated =now()";
  		 mysql_query($insQry)or die (mysql_error());
		
		unset($_SESSION['biz_color_err']);
		unset($_SESSION['biz_color']);
		$_SESSION['biz_color_err']['colors'] = 'Color added successfully!';
		header('location:'.ruadmin.'home.php?p=colors'); exit;
  }
  
}

if ( isset ($_POST['Updatecolor'])){
//print_r($_REQUEST); exit;
	    unset($_SESSION['biz_color_err']);
	    unset($_SESSION['biz_color']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(trim($v ));
			$_SESSION['biz_color'][$k]=$v;
		}
	$flgs = false;
	
		///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_color_err']['name'] = 'Please enter color name';
		$flgs = true;
	
	}
	
	if($code==''){
		$_SESSION['biz_color_err']['code'] = 'Please enter color code';
		$flgs = true;
	
	}

		
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=colors'); exit;
		
  }else{
  		

 		$insQry2 ="Update color set name ='$name',
									code_name = '$code_name',
									ref_code = '$ref_code',
									code ='$code',
									price = '$price',
									dated =now()
									where Id =$Id";
  		mysql_query($insQry2)or die (mysql_error());

		unset($_SESSION['biz_color_err']);
		unset($_SESSION['biz_color']);
		$_SESSION['biz_color_err']['colors'] = 'Color Updated Successfully!';
		header('location:'.ruadmin.'home.php?p=colors'); exit;
  }
}

?>