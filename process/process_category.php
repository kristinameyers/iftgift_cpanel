<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once ('../inc/functii.php');
mysql_query("SET NAMES 'utf8'");
unset($_SESSION['biz_cat_err']);
unset($_SESSION['biz_cat']);
//print_r($_REQUEST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$catid  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from ".tbl_category." where catid  = $catid ");
	
		$_SESSION['biz_cat_errs']['categories'] = 'Category deleted !';
		header('location:'.ruadmin.'home.php?p=category_manage'); exit;			
	
	} 


if (isset($_POST['Savecategory'])){ 

     	unset($_SESSION['biz_cat_err']);
	    unset($_SESSION['biz_cat']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['biz_cat'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////cat_name valcatidation////////	
	if($cat_name==''){
		$_SESSION['biz_cat_err']['cat_name'] = 'Please enter category name';
		$flgs = true;
	
	}
	
	$group = $you_cat.$sjester;
	if($group== ''){
		$_SESSION['biz_cat_err']['group'] = 'Select atleast one group';
		$flgs = true;
	
	}
	
	if($sortorder==''){
		$_SESSION['biz_cat_err']['sortorder'] = 'Please enter category sortorder';
		$flgs = true;
	
	}
	 
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=category_add'); exit;
		
  }else{
   			$insQry ="insert into ".tbl_category." set cat_name ='".mysql_real_escape_string(stripslashes(trim($cat_name)))."',
									sortorder = '$sortorder',
									status = '$status',
									you_cat = '$you_cat',
									sjester = '$sjester',
									cat_type = '1'";
  		 mysql_query($insQry)or die (mysql_error());
		
		unset($_SESSION['biz_cat_err']);
		unset($_SESSION['biz_cat']);
		$_SESSION['biz_cat_errs']['categories'] = 'Category added successfully!';
		header('location:'.ruadmin.'home.php?p=category_manage'); exit;
  }
  
}

if ( isset ($_POST['Updatecategory'])){
//print_r($_REQUEST); exit;
	    unset($_SESSION['biz_cat_err']);
	    unset($_SESSION['biz_cat']);
	
		foreach ($_POST as $k => $v ){
			$$k =  $v;
			$_SESSION['biz_cat'][$k]=$v;
		}
	$flgs = false;
	
		///////////////////////cat_name valcatidation////////	
	if($cat_name==''){
		$_SESSION['biz_cat_err']['cat_name'] = 'Please enter category name';
		$flgs = true;
	
	}
	
	/*$group = $you_cat.$sjester;
	if($group== ''){
		$_SESSION['biz_cat_err']['group'] = 'Select atleast one group';
		$flgs = true;
	
	}*/
	
	if($sortorder==''){
		$_SESSION['biz_cat_err']['sortorder'] = 'Please enter category sortorder';
		$flgs = true;
	
	}

		
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=category_manage'); exit;
		
  }else{
  		
		/*foreach ($_POST['occassion'] as $occassion) {
	 	$value1 = $occassion;
    	$pro[] = array('occassionid' => "$value1");
	}
	
		$json = json_encode($pro);	
		ocassionid	=	'$json',
		*/
		$insQry2 ="Update ".tbl_category." set 	cat_name ='".mysql_real_escape_string(stripslashes(trim($cat_name)))."',
									sortorder ='$sortorder',
									status = '$status',
									you_cat = '$you_cat',
									sjester = '$sjester',
									cat_type = '1'
									where catid =$catid";
  		mysql_query($insQry2)or die (mysql_error());
		
		unset($_SESSION['biz_cat_err']);
		unset($_SESSION['biz_cat']);
		$_SESSION['biz_cat_errs']['categories'] = 'Category Updated Successfully!';
		header('location:'.ruadmin.'home.php?p=category_manage'); exit;
  }
}


//////////////////////////////Add catogries////////////////////////////////////////////////////////////	
if ( isset ($_POST['subcategory']))
{
   		unset($_SESSION['biz_subcat_err']);
	    unset($_SESSION['biz_subcat']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(trim($v ));
			$_SESSION['biz_subcat'][$k]=$v;
		}
	
   $qrysrc = "select count(catid) from  ".tbl_category." where cat_name='".$cat_name."' and p_catid = ".$cat."";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['biz_subcat_err']['cat_name']='Sub Category already exits.';
	  header("location:".ruadmin."home.php?p=category_sub");
	  exit;

	}
	
   $flag=false;
   if(!$cat_name)
   {
	  $_SESSION['biz_subcat_err']['cat_name']='Please Enter Sub Category';
	  $flag=true;
   }
   
   if(!$sortorder)
   {
	  $_SESSION['biz_subcat_err']['ordererror']='Please Enter Sortorder';
	  $flag=true;
   }

   if($flag)
	{	
		header('location:'.ruadmin.'home.php?p=category_sub'); exit;
	} else {	
		$sql = "INSERT INTO ".tbl_category." set cat_name='".mysql_real_escape_string(stripslashes(trim($cat_name)))."' , p_catid = ".$cat.",sortorder = ".$sortorder.",status = ".$status."";
		mysql_query($sql);
		//$catId = mysql_insert_id();
		
		$_SESSION['statuss']='Sub Category added successfully';
		header("location:".ruadmin."home.php?p=category_sub");
		exit;
	}
}

/////////////////////////Update Category//////////////////////////////////////////////////////
if ( isset ($_POST['editsubcategory']))
{
	$pcat=addslashes($_POST['cat']);
	$catid=addslashes($_POST['catid']);
	$sortorder=addslashes($_POST['sortorder']);
	$status=addslashes($_POST['status']);
	$cat_name=addslashes($_POST['title']);
	$sql = "UPDATE ".tbl_category." SET cat_name='".mysql_real_escape_string(stripslashes(trim($cat_name)))."' , p_catid = ".$pcat.", sortorder=".$sortorder.",status=".$status." where catid='".$catid."' ";
	mysql_query($sql);
	
	//$sqlbus = "UPDATE business SET subcat='".$_POST['title']."' where subcat='".$_POST['ctitle']."' ";
	//mysql_query($sqlbus);	
	
	$_SESSION['statuss']='Sub Category Updated successfully';
	header("location:".ruadmin."home.php?p=category_sub");
	exit;
}
	
	/////////////////////////Delet Category//////////////////////////////////////////////////////
if ( isset ($_GET['action'])  and  ($_GET['action']=='delsubcat'))
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM ".tbl_category." where catid='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Sub Category  Deleted successfully';
		header("location:".ruadmin."home.php?p=category_sub&page=".$_GET['page']);
		exit;
	}
	exit;
}

?>