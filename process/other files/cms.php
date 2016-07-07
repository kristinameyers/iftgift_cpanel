<?php
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');

	foreach($_POST  as $key => $value)
	{
	   $$key = $value;
	}
	foreach($_GET as $key => $value)
	{
	   $$key = $value;
	}

	
	if ( isset ($delete_cms ))
	{
		$_SESSION['msg']['delete'] = 'record deleted successfully!';
		mysql_query(" delete from cms where id ='$cmsId' " );
		header('location:'.ruadmin.'home.php?p='.$page);
		exit;	
	}
	
	foreach($titles as $k =>$v)
	{
	
		$page 	= trim( addslashes( $pages[$k] ) );
		$title 	= trim( addslashes( $titles[$v] ) );
		$content 	= trim( addslashes( $contents[$k] ) );
		$Id		= trim( addslashes( $Ids[$k] ) );
		if ($Id =='' ) 
			mysql_query(" insert into cms set page = '$page' ,title='$title' , content ='$content' ");
		else
			mysql_query(" update into cms set page = '$page' ,title='$title' , content ='$content' where id= $Id ");
	}
	
	
	$_SESSION['msg']['delete'] = 'record saved successfully!';
	header('location:'.ruadmin.'home.php?p='.$page);
	exit;
?>	