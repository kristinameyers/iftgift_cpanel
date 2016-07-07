<?php
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');


if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$Id  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from cms where Id  = $Id ");
	
		$_SESSION['biz_image_err']['images'] = 'Text deleted !';
		header('location:'.ruadmin.'home.php?p='.$_GET['page']);exit;		
	
	} 

if (isset ($_POST['Saveabout']))
{
    $title = addslashes($_POST['title']); 
	$content = addslashes($_POST['content']);
	$page = $_POST['page']; 
	
	$qry="insert into cms set content = '".$content."'  , title ='".$title."',  page = '".$page."'";

	@mysql_query($qry);
	$_SESSION['msgText'] = 'Saved Successfuly !';
	header('location:'.ruadmin.'home.php?p='.$_POST['page']);exit;
}

if (isset ($_POST['Updateabout']))
{
    $title = addslashes($_POST['title']); 
	$content = addslashes($_POST['content']);
	$id = $_POST['id']; 
	
	$qry="update cms set content = '".$content."'  , title ='".$title."' where  id = '".$id."'";

	@mysql_query($qry);
	$_SESSION['msgText'] = 'Updated Successfuly !';
	header('location:'.ruadmin.'home.php?p='.$_POST['page']);exit;
}

?>