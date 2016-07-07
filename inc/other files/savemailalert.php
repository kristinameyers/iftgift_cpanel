<?php
require_once("../../connect/connect.php");
require_once("../security.php");

if (isset ($_POST['SaveTextData']))
{
	$adminname =	$_POST['adminname'];
	$toadmin =	$_POST['toadmin'];
	$touser =	$_POST['touser'];
	$txtData =	addslashes($_POST['txtData']);	
	$txtSubject =$_POST['txtSubject'];	
	$txtSavePage =$_POST['savepage'];
	
	$rsCMS=mysql_query("select * from emails where type ='".$txtSavePage."'");
	if ( mysql_num_rows($rsCMS)>0	)
	{		
		$qry="update emails set adminname = '".$adminname."',toadmin = '".$toadmin."',touser = '".$touser."',subject = '".$txtSubject."',body = '".$txtData."'  where type ='".$txtSavePage."'";
	}else if($txtSavePage != ""){
		$qry="insert into emails set adminname = '".$adminname."',toadmin = '".$toadmin."',touser = '".$touser."',subject = '".$txtSubject."',body = '".$txtData."'  , type ='".$txtSavePage."'";
	}
	mysql_query($qry) or die(mysql_error());
	$_SESSION['msgText']='Saved Successfuly !';
	header('location:'.ruadmin.'home.php?p=emails_alert&type='.$txtSavePage);		
}
?>