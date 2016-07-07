<?php
ob_start();	
include ("../connect/connect.php");	
include ("../config/config.php");	
include("common/libmail.php");		

/*...............................Forgot Passsword..................................................*/	

if ( isset ($_POST['sendpassword'])) 
{
	if (empty($_POST['name']))
	{
		$msg = base64_encode("Please enter your account email!");
		header("Location:password_support.php?msg=$msg");
		exit;
	}
		
	$qrylogin = "SELECT * FROM ".tbl_user." WHERE email  = '".$_POST['name']."' and (type = 'a' or type = 's')";
	$rslogin = $db->get_row($qrylogin,ARRAY_A); 
	$email=$rslogin['email'];
	 if($email != $_POST['name'])
	{
		$msg = base64_encode("Invalid Login email!");
		header("Location:password_support.php?msg=$msg");
		exit;
	}
	else
	{
	
		$possible = '23456789bcdfghjkmnpqrstvwxyz'; 
			$characters =7;
			$code = '';
			$i = 0;
			while ($i < $characters) { 
				$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$i++;
			}
			
			$password  = md5($code);
			$userId =$rslogin['userId'];
			
			 $QryStr ="update ".tbl_user." set 	password ='$password' where   userId = $userId "; 
			 mysql_query($QryStr)or die (mysql_error());
	
		$email_text = "Dear ".$rslogin['first_name']." ".$rslogin['last_name'].",<br><br>Here is the required informatioin:-<br><br>Useranme:-"
					.$rslogin['username'].
					" <br>Password:- "
				.$code."<br><br>Cheers,<br> ". $rslogin['first_name']." ".$rslogin['last_name'];
	
		$subject="Forget Password";
		
		$m = new Mail(); // create the mail
		$m->From($rslogin['email']);
		$m->To($rslogin['email']);
		$m->Subject($subject);
		$m->Body($email_text);
		
		//$m->Attach( "cvs/customers.csv", "application/csv", "attachment" );
		$m->Send(); 
		//$filepath="cvs/customers.csv";
		$msg = base64_encode("Password sent to your mailbox!");exit;	
		header("Location:password_support.php?msg=$msg ");
		exit;
	}
}	
?>