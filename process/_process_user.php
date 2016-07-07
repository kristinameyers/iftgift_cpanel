<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once("../security.php");
require_once ('../inc/functii.php');


if ( isset ($_POST['UpdateMember'])){
	
	unset($_SESSION['user_update_err']);
	unset($_SESSION['user_update']);
	
	foreach ($_POST as $k => $v )
	{
		$$k =  addslashes(trim($v ));
		$_SESSION['user_update'][$k]=$v;
	
	}
		$flgs = false;
//---------------------------Email validation-----------------------//
		if(!$email)
		{
			$_SESSION['user_update_err']['email'] = $_ERR['register']['email'];
			$flgs = true;
		
		}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['user_update_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}else{
	
			    $sqlcount = "select count(*) as ecount from ".tbl_user." where email like '$email' and type = '$type' and userId != $userId ";
				$arrcount=mysql_query($sqlcount);
				$rowData =mysql_fetch_array($arrcount);
				if($rowData['ecount']> 0)
				{
					$_SESSION['user_update_err']['email'] = $_ERR['register']['emaile'];
					$flgs = true;
	
				}
			}
	
		}

//-----------------first name validation--------------------//
	   if(verifyName($first_name))
		{
		
			$_SESSION['user_update_err']['first_name'] = $_ERR['register']['first_name'];
			$flgs = true;
		}
//----------------------last name validation-----------------//
		if(verifyName($last_name))
		{
			$_SESSION['user_update_err']['last_name'] = $_ERR['register']['last_name'];
			$flgs = true;
		}
//--------------------password validation---------------------//
		
		if($password != '' & $cpassword!=''){
			if(verifypassword($password))
			{    $_SESSION['user_update_err']['password'] = $_ERR['register']['passg'];
				$flgs = true;
			}
		
//----------------- Check if the password matched---------------//
			
			if($password != $cpassword)
			{
				$_SESSION['user_update_err']['cpassword'] = $_ERR['register']['passc'];
				$flgs = true;
			}
			$passwrd = " password ='".md5($password)."',";
		}

	  if($flgs){
		header('location:'.ruadmin.'home.php?p=profilesettings&userId='.$userId); exit;
	  }else{
			

				$upd_user ="Update ".tbl_user." set 	first_name 	='$first_name',
												last_name	='$last_name',
												email		='$email',
												".$passwrd."
												dated 	=now()
										where   userId 		=$userId";
										
				
				$db->query($upd_user);
				unset($_SESSION['user_update_err']);
				unset($_SESSION['user_update']);
						
			$_SESSION['user_update_err']['useradded'] = 'User Updated Successfully!';
				header('location:'.ruadmin.'home.php?p=profilesettings&userId='.$userId);
			exit;
	  }
}


/////////////////////////////////////////Update User///////////////////////////////////////////////////////

if ( isset ($_POST['UpdateUser'])){
	
	unset($_SESSION['users_update_err']);
	unset($_SESSION['users_update']);
	
	foreach ($_POST as $k => $v )
	{
		$$k =  addslashes(trim($v ));
		$_SESSION['users_update'][$k]=$v;
	
	}
		$flgs = false;
//---------------------------Email validation-----------------------//
		if(!$email)
		{
			$_SESSION['users_update_err']['email'] = $_ERR['register']['email'];
			$flgs = true;
		
		}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['users_update_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}else{
	
			     $sqlcount = "select count(*) as ecount from ".tbl_user." where email like '$email' and userId != $userId ";
				$arrcount=mysql_query($sqlcount);
				$rowData =mysql_fetch_array($arrcount);
				if($rowData['ecount']> 0)
				{
					$_SESSION['users_update_err']['email'] = $_ERR['register']['emaile'];
					$flgs = true;
	
				}
			}
	
		}

//-----------------first name validation--------------------//
	   if(verifyName($first_name))
		{
		
			$_SESSION['users_update_err']['first_name'] = $_ERR['register']['first_name'];
			$flgs = true;
		}
//----------------------last name validation-----------------//
		if(verifyName($last_name))
		{
			$_SESSION['users_update_err']['last_name'] = $_ERR['register']['last_name'];
			$flgs = true;
		}
//--------------------password validation---------------------//
		
		if($password != '' & $cpassword!=''){
			if(verifypassword($password))
			{    $_SESSION['users_update_err']['password'] = $_ERR['register']['passg'];
				$flgs = true;
			}
		
//----------------- Check if the password matched---------------//
			
			if($password != $cpassword)
			{
				$_SESSION['users_update_err']['cpassword'] = $_ERR['register']['passc'];
				$flgs = true;
			}
			$passwrd = " password ='".md5($password)."',";
		}

	  if($flgs){
		header('location:'.ruadmin.'home.php?p=user_edit'); exit;
	  }else{
			

				$upd_user ="Update ".tbl_user." set 	first_name 	='$first_name',
												last_name	='$last_name',
												status = '$status',
												email		='$email',
												".$passwrd."
												dated 	=now()
										where   userId 		=$userId";
										
				
				$db->query($upd_user);
				unset($_SESSION['users_update_err']);
				unset($_SESSION['users_update']);
						
			$_SESSION['users_update_errs']['useraddeds'] = 'User Updated Successfully!';
				header('location:'.ruadmin.'home.php?p=user_manage');
			exit;
	  }
}


if ( isset ($_GET['action'])  and  ($_GET['action']=='delluser'))
{
			
	$userId  =$_GET['userId'];
	
	$get_umail = mysql_fetch_array(mysql_query("select email from ".tbl_user." where userId = '".$userId."'"));
	$uemail = $get_umail['email'];
	
	$get_remail = mysql_query("select email from ".tbl_recipient." where email = '".$uemail."'");
	if(mysql_num_rows($get_remail) > 0) {
		$remail = mysql_fetch_array($get_remail);
		$remail_Sql = mysql_query("delete from ".tbl_recipient." where email  = '".$remail['email']."'");
		
	}  
	
	$point_Sql = mysql_query("delete from ".tbl_userpoints." where userId  = $userId ");
	
	$biz_Sql = mysql_query("delete from ".tbl_user." where userId  = $userId ");
	
		$_SESSION['users_update_errs']['useraddeds'] = 'User deleted !';
		header('location:'.ruadmin.'home.php?p=user_manage'); exit;			
	
	} 
?>