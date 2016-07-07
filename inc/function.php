<?php
	
	
	
	$_ERR['register']['dob'] = 'Date of birth not valid.';
	
	$_ERR['register']['sc'] = 'invalid Security Code';
	
	$_ERR['register']['phone_number'] = 'Please enter a valid phone number.';
	
	$_ERR['register']['emaile'] = 'The email is already in use by someone else, please try another one.';
	
	$_ERR['register']['passc'] = 'The password confirmation is not the same as password.';
	
	
	
	///////////////////////////////////////////////////////////////////////////
	
	function phone_number($Phone){
	// Parola
	$sPhone = str_replace('-','',$Phone);
	if(preg_match("#^[0-9]{10}+$#", $sPhone))
	{
		if($sPhone != $Phone)
			if( !preg_match("#^[0-9]{3}-[0-9]{3}-[0-9]{4}+$#", $Phone) ) 
				return false;
	}	
	else
	{
		return false;
	}
	return true;
}

	function uservarification()
	
	{
	
		if(empty($_SESSION['userrecord']))
	
		{
	
		
	
		}
	
	}
	
	function dayofweek($selecteddate)//accept date in YYYY-MM-DD format
	
	{
	
		//This function consider 'sunday' as first day and its numeric value is 0 and last day is saturday and its numeric value is 6
	
		$dayofweek = array('mdays','mday','wday');
	
		list($y,$m,$d) = explode("-",$selecteddate);
	
		$dayofweek[mdays] = $mdays=date("t",mktime(0,0,0,$m,1,$y)); //days in the current month
	
		$dayofweek[mday] = date('w',mktime(0,0,0,$m,1,$y)); // day of the week the month started with
	
		$dayofweek[wday] = ($d+$first_day-1)%7;
	
		return $dayofweek;
	
	}
	
	
	
	function sendemail($userID,$type,$confirmationLink="")
	
	{
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		
	
		$user = @mysql_fetch_array(mysql_query("select * from tbl_user where id='".$userID."'"));
	
		$username = $user['username'];
	
		$email = $user['email'];
	
		$pass = $user['password'];
	
		
	
		$admin = @mysql_fetch_array(mysql_query("select * from tbl_admin"));
	
		$adminMail = $admin['admin_email'];
	
		// get mail contents here (e.g. subject,body)
	
		$result = @mysql_query("select * from tblemails where type='".$type."'") or die(mysql_error());
	
		$content = @mysql_fetch_array($result);
	
		$subject = $content['subject'];
	
		$body = $content['content'];
	
		
	
		$from = $headers."From: ".$adminMail;
	
		$newmsg = str_replace("{{UserName}}",$username,$body);
	
		$newmsg2 = str_replace("{{Email}}",$email,$newmsg);
	
		$newmsg3 = str_replace("{{Password}}",$pass,$newmsg2);
	
		$message = str_replace("{{ConfirmationLink}}",$confirmationLink,$newmsg3);
	
		//echo "From:".$adminMail.", Subject:".$subject.", Body:".$message;
	
		$mailsent = mail($email,$subject,$message,$from);
	
		//return $mailsent;
	
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	$_ERR['register']['passg'] = 'The password syntax must contain minimum 6 characters in lowercase, uppercase or numeric.';
	
	function vpparola ($valoare)
	
	{
	
		// Parola
	
		if (!preg_match("#^[a-zA-Z0-9]+$#", $valoare) || strlen($valoare) < 6)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	
	
	$_ERR['register']['userValidate'] = 'The user name must contain minimum 4 valid characters (a-z, A-Z, 0-9, _).';
	
	function ValidateUsername ($username)
	
	{
	
	
	
		if(!preg_match("#^[a-zA-Z0-9\_]+$#", $username) || strlen($username) < 4)
	
		{
	
			return true;
	
		}	
	
	}
	
	
	
	$_ERR['register']['userVerify'] = 'The user name already exists, please try another one.';
	
	function VerifyDBUsername ($username)
	
	{
	
	
	
		$rsVU =mysql_query("select * from tblusers where username = '".$username."' ");
	
		if ( mysql_num_rows($rsVU)> 0 ) return false; else return true;
	
		
	
	}
	
	
	
	$_ERR['register']['cpname'] = 'The company name must contain minimum 2 valid characters (a-z, A-Z).';
	
	$_ERR['register']['name'] = 'The name must contain minimum 2 valid characters (a-z, A-Z).';
	
	
	
	function verifyName ($str)
	
	{
	
		// Nume
	
		if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function verifyName2($str)
	
	{
	
		// Preume
	
		if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	
	
	
	
	$_ERR['register']['emailg'] = 'The email syntax is not valid.';
	
	function vpemail ($valoare)
	
	{
	
		// Email
	
		if (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $valoare) || empty($valoare))
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	
	
	
	
	function reducere($text)
	
	{
	
		$a = array("\r", "\t", "\n");
	
		$r = str_replace($a, '', $text);
	
		return $r;
	
	}
	
	
	
	// Functii pregmatch de verificare
	
	
	
	function vState ($valoare)
	
	{
	
		// Parola
	
		if (!preg_match("#^[0-9]+$#", $valoare) || strlen($valoare) < 5)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function vpphone ($valoare)
	
	{
	
		// Parola
	
		if (!preg_match("#^[0-9]+$#", $valoare)/* || strlen($valoare) < 6*/)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function vpparolac ($valoare, $valoarec)
	
	{
	
		// Parola confirmare
	
		if (!($valoare == $valoarec))
	
		{
	
			return true;
	
		}
	
	}
	
	function vpparolav ($tb, $valoare)
	
	{
	
		// Utilizator existent
	
		$parolav	=	selectaren("*", $tb, "and parola = '".md5($valoare)."' and id = ".$_SESSION['sesID']);
	
		if ($parolav != 1)
	
		{
	
			return true;
	
		}
	
	}
	
	function vpemaile ($tb, $valoare)
	
	{
	
		// Email existent
	
		$emaile	=	selectaren("*", $tb, "and lower(email) = '".strtolower($valoare)."'");
	
		if ($emaile> 0)
	
		{
	
			return true;
	
		}
	
	}
	
	function vpemailep ($tb, $valoare)
	
	{
	
		// Email existent profil
	
		$sqlq	=	selectare("email", $tb, "and id = ".$_SESSION['sesid'], 0, 0, 0);
	
		$rand	=	mysql_fetch_array($sqlq);
	
		$email	=	$rand['email'];
	
		if ($email	!=	$valoare)
	
		{
	
			$emaile	=	selectaren("email", $tb, "and lower(email) = '".strtolower($valoare)."'");
	
			if ($emaile> 0)
	
			{
	
				return true;
	
			}
	
		}
	
	}
	
	//------------------------
	
	function vpemailep1 ($tb, $valoare)
	
	{
	
		// Email existent profil
	
		$sqlq	=	selectare("email", $tb, "and id = ".$_SESSION['id_modificare_admin'], 0, 0, 0);
	
		$rand	=	mysql_fetch_array($sqlq);
	
		$email	=	$rand['email'];
	
		if ($email	!=	$valoare)
	
		{
	
			$emaile	=	selectaren("email", $tb, "and lower(email) = '".strtolower($valoare)."'");
	
			if ($emaile> 0)
	
			{
	
				return true;
	
			}
	
		}
	
	}
	
	//-----------------------------
	
	
	
	
	
	function vpemailc ($valoare, $valoarec)
	
	{
	
		// Email confirmare
	
		if (!($valoare == $valoarec))
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function wordLimit($string, $length = 50, $ellipsis = '...')
	
	{
	
	   return count($words = preg_split('/\s+/', ltrim($string), $length + 1))> $length ?
	
		   rtrim(substr($string, 0, strlen($string) - strlen(end($words)))) . $ellipsis :
	
		   $string;
	
	}
	
	
	
	function stringLimit($string, $length = 50, $ellipsis = '...')
	
	{
	
	   return strlen($fragment = substr($string, 0, $length + 1 - strlen($ellipsis))) < strlen($string) + 1 ?
	
		   preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
	
	}
	
	function splitlimit($string, $length = 50, $ellipsis = '...')
	
	{
	
	   if (strlen($string)> $length)return substr($string, 0, $length) . ' ' . $ellipsis;
	
	   else return $string;
	
	}
	
	
	
	function getUserName($id){
	
		$rs = mysql_query("SELECT username FROM tbl_user WHERE id = '".$id."'") or die(mysql_error());
	
		$row = mysql_fetch_array($rs);
	
		return $row['username'];
	
	}
	
	
	
	function countFav($id){
	
		$rs = mysql_query("SELECT * FROM tbl_fav WHERE user_id = '".$id."'") or die(mysql_error());
	
		return mysql_num_rows($rs);
	
	}
	
	function countFriend($id){
	
		$rs = mysql_query("SELECT * FROM tbl_userfriend WHERE user_id = '".$id."'") or die(mysql_error());
	
		return mysql_num_rows($rs);
	
	}
	
	function countVideos($id){
	
		$rs = mysql_query("SELECT * FROM tbl_videos WHERE user_id = '".$id."'") or die(mysql_error());
	
		return mysql_num_rows($rs);
	
	}
/********************Mail Function SMTP*****************/
	function sendmail_admin($to,  $subject, $message,$headers){
 					 
		global $error;
		include_once('../../phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();  // create a new object
		$mail->IsHTML(true); 
		$mail->IsSMTP(); // enable SMTP		

	
		$mail->SMTPAuth		= true;  // authentication enabled
		$mail->SMTPSecure 	= "ssl"; // secure transfer enabled REQUIRED for GMail			
		$mail->Host 		= 'gator4041.hostgator.com';
		$mail->Port 		= '465'; 
		$mail->Username 	= 'info@iftgift.com';  
		$mail->Password 	= 'iftGiftxx22'; 	

		//print_r($mail);
		$mail->SetFrom('info@iftgift.com','Iftgift');	

		$mail->AddReplyTo('info@iftgift.com','Iftgift');	
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test...
		$mail->AddAddress($to);	
		$sends=$mail->send();
		if($sends){
			return "SUCCESS";
		}
}
	
	
?>