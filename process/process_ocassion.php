<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once ('../inc/functii.php');

unset($_SESSION['biz_ocs_err']);
unset($_SESSION['biz_ocs']);
//print_r($_REQUEST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$catid  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from ".tbl_occasion." where occasionid  = $catid ");
	
		$_SESSION['biz_ocs_errs']['ocassions'] = 'Ocassaion deleted !';
		header('location:'.ruadmin.'home.php?p=ocassion_manage'); exit;			
	
	} 


if (isset($_POST['Saveocassion'])){ 

     	unset($_SESSION['biz_ocs_err']);
	    unset($_SESSION['biz_ocs']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['biz_ocs'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////cat_name valcatidation////////	
	if($occasion_name==''){
		$_SESSION['biz_ocs_err']['occasion_name'] = 'Please enter Ocassion name';
		$flgs = true;
	
	}
	
	
	if($group== ''){
		$_SESSION['biz_ocs_err']['group'] = 'Select atleast one group';
		$flgs = true;
	
	}
	
	if($method == '1' || $method == '2') {
	if($categories == '' || $categories == 'Select options'){
		$_SESSION['biz_ocs_err']['categories'] = 'Please select categories';
		$flgs = true;
	
	}
  }
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=ocassion_add'); exit;
		
  }else{
  		if($method == '1' || $method == '2') {
  		$commaListcat = implode(',', $categories);
		
		//echo $commaListcat;exit;
  		
   			$insQry ="insert into ".tbl_occasion." set occasion_name ='".mysql_real_escape_string(stripslashes(trim($occasion_name)))."',
									p_occasionid = '$group',
									status = '$status',
									occasion_type = '0',
									method = '$method',
									cat_id = '".mysql_real_escape_string(stripslashes(trim($commaListcat)))."'";
		} else {							
			$insQry ="insert into ".tbl_occasion." set occasion_name ='".mysql_real_escape_string(stripslashes(trim($occasion_name)))."',
									p_occasionid = '$group',
									status = '$status',
									occasion_type = '0',
									method = '$method'";						
			}//echo $insQry;exit;						
  		 mysql_query($insQry)or die (mysql_error());
		
		unset($_SESSION['biz_ocs_err']);
		unset($_SESSION['biz_ocs']);
		$_SESSION['biz_ocs_errs']['ocassions'] = 'Ocassion added successfully!';
		header('location:'.ruadmin.'home.php?p=ocassion_manage'); exit;
  }
  
}

if ( isset ($_POST['Editocassion'])){
//print_r($_REQUEST); exit;
	    unset($_SESSION['biz_ocs_err']);
	    unset($_SESSION['biz_ocs']);
	
		foreach ($_POST as $k => $v ){
			$$k =  $v;
			$_SESSION['biz_ocs'][$k]=$v;
		}
	$flgs = false;
	
		///////////////////////cat_name valcatidation////////	
	if($occasion_name==''){
		$_SESSION['biz_ocs_err']['occasion_name'] = 'Please enter Ocassion name';
		$flgs = true;
	
	}
	
	
	if($group== ''){
		$_SESSION['biz_ocs_err']['group'] = 'Select atleast one group';
		$flgs = true;
	
	}
	
	if($method == '1' || $method == '2') {
	if($categories == '' || $categories == 'Select options'){
		$_SESSION['biz_ocs_err']['categories'] = 'Please select categories';
		$flgs = true;
	
	}
  }
		
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=ocassion_edit&occasionid='.$occasionid); exit;
		
  }else{
  		
		if($method == '1' || $method == '2') {
		$commaListcat = implode(',', $categories);
		$insQry2 ="Update ".tbl_occasion." set 	occasion_name ='".mysql_real_escape_string(stripslashes(trim($occasion_name)))."',
									p_occasionid = '$group',
									status = '$status',
									occasion_type = '0',
									method = '$method',
									cat_id = '".mysql_real_escape_string(stripslashes(trim($commaListcat)))."'
									where occasionid =$occasionid";
		} else {
		$insQry2 ="Update ".tbl_occasion." set 	occasion_name ='".mysql_real_escape_string(stripslashes(trim($occasion_name)))."',
									p_occasionid = '$group',
									status = '$status',
									occasion_type = '0',
									method = '$method',
									cat_id = ''
									where occasionid =$occasionid";
		}							
  		mysql_query($insQry2)or die (mysql_error());
		
		unset($_SESSION['biz_ocs_err']);
		unset($_SESSION['biz_ocs']);
		$_SESSION['biz_ocs_errs']['ocassions'] = 'Ocassion Updated Successfully!';
		header('location:'.ruadmin.'home.php?p=ocassion_manage'); exit;
  }
}


//////////////////////////////Add Ocassion Group////////////////////////////////////////////////////////////	
if ( isset ($_POST['ocassiongroup']))
{
   		unset($_SESSION['biz_group_err']);
	    unset($_SESSION['biz_group']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(trim($v ));
			$_SESSION['biz_group'][$k]=$v;
		}
	
   $qrysrc = "select count(occasionid) from  ".tbl_occasion." where occasion_name='".$group_name."' and p_occasionid = '0'";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['biz_group_err']['group_name']='Ocassion Group already exits.';
	  header("location:".ruadmin."home.php?p=ocassion_group_manage");
	  exit;

	}
	
   $flag=false;
   if(!$group_name)
   {
	  $_SESSION['biz_group_err']['group_name']='Please Enter Ocassion Group';
	  $flag=true;
   }

   if($flag)
	{	
		header('location:'.ruadmin.'home.php?p=ocassion_group_manage'); exit;
	} else {	
		$sql = "INSERT INTO ".tbl_occasion." set occasion_name='".mysql_real_escape_string(stripslashes(trim($group_name)))."' , p_occasionid = '0',status = ".$status."";
		mysql_query($sql);
		
		$_SESSION['statusss']='Group added successfully';
		header("location:".ruadmin."home.php?p=ocassion_group_manage");
		exit;
	}
}

/////////////////////////Update Ocassion Group//////////////////////////////////////////////////////
if ( isset ($_POST['editgroup']))
{
	$catid=addslashes($_POST['catid']);
	$status=addslashes($_POST['status']);
	$cat_name=addslashes($_POST['title']);
	$sql = "UPDATE ".tbl_occasion." SET occasion_name='".mysql_real_escape_string(stripslashes(trim($cat_name)))."' , p_occasionid = '0',status=".$status." where occasionid='".$catid."' ";
	mysql_query($sql);
	
	$_SESSION['statusss']='Group Updated successfully';
	header("location:".ruadmin."home.php?p=ocassion_group_manage");
	exit;
}
	
	/////////////////////////Delet Ocassion Group//////////////////////////////////////////////////////
if ( isset ($_GET['action'])  and  ($_GET['action']=='delgroup'))
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM ".tbl_occasion." where occasionid='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statusss']='Group  Deleted successfully';
		header("location:".ruadmin."home.php?p=ocassion_group_manage&page=".$_GET['page']);
		exit;
	}
	exit;
}

?>