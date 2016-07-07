<?php 
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');
	//unset($_SESSION['emailsent']);
if(isset($_POST['slect_all']) and count($_POST['slect_all'])> 0 )
{
	$subject = $_POST['txtSubject'];
	$subject = $_POST['txtSubject'];
	$message = $_POST['txtData'];
	$mailfrom = $_POST['mailfrom'];
	
	if(trim($mailfrom)==''){
		$mailfrom='admin@piecesbyfarah.com';
	}
	foreach($_POST['slect_all'] as $emailName)
	{
		$arr = explode('{:',$emailName);
		$fName = $arr[0];
		$message = str_replace('{{Username}}',$fName,$message);
		$email = $arr[1];
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: ' . $fName . ' <' . $email . '>' . "\r\n";
		$headers .= 'From: piecesbyfarah.com <'.$mailfrom.'>' . "\r\n";
		
		//echo "<br> == ".$email." == ".$subject." == ".$message." = ".$headers;
		//exit;
		
		// Mail it

		mail($email, $subject, $message, $headers);
		unset($headers); 
		//sleep(1);
		//echo $email."<br>".$subject."<br>".$BODY."<br>".$headers;
	}

	header('location:'.ruadmin.'home.php?p=emails_bulk&s=1');
	exit;
}
header('location:'.ruadmin.'home.php?p=emails_bulk&s=0');
exit;
?>