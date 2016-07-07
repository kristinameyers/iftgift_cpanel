<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once("../security.php");

if(isset($_POST['SaveEmail']))
 {
	  foreach($_POST as $key=>$value)
	  {
	  	 $$key=addslashes(trim($value));
	  }

 	$rsCMS=mysql_query("select * from ".tbl_emails." where type ='".$type."'");
	if ( mysql_num_rows($rsCMS)>0	)
	{		
		$qry="update ".tbl_emails." set adminname = '".$adminname."',toadmin = '".$toadmin."',touser = '".$touser."',subject = '".$subject."',body = '".$txtData."'  where type ='".$type."'";
	}else {
		 $qry="insert into ".tbl_emails." set adminname = '".$adminname."',toadmin = '".$toadmin."',touser = '".$touser."',subject = '".$subject."',body = '".$txtData."'  , type ='".$type."'";
	}
	//echo  $qry; exit;
	mysql_query($qry) or die(mysql_error());
	$_SESSION['msgText']='Saved Successfuly !';
	//echo ruadmin.'home.php?p=emails_alert&type='.$type;exit;
	header('location:'.ruadmin.'home.php?p=emails_alert&type='.$type);
	
 }
	

?>