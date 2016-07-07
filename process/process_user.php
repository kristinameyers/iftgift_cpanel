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
	
	$get_umails = "select email from ".tbl_user." where userId = '".$userId."'";
	$get_umail=$db->get_row($get_umails,ARRAY_A);
	$uemail = $get_umail['email'];
	
	 $get_remail="select email from ".tbl_recipient." where email = '".$uemail."'"; 
		$get_remails=$db->get_row($get_remail,ARRAY_A);
		if($get_remails){ echo $get_remails['email'];
		$remail_Sql=$db->query("delete from ".tbl_recipient." where email  = '".$remail['email']."' ");
	}  
	
	$user_detail="SELECT * from  gift_payment WHERE userId  = $userId"; 
	$usersss=$db->get_row($user_detail,ARRAY_A);
	if($usersss){
		$del_payment=$db->query("delete from  gift_payment where userId  = $userId"); 
	}
	$point_Sql=$db->query("delete from ".tbl_userpoints." where userId  = $userId ");
	$biz_Sql=$db->query("delete from ".tbl_user." where userId  = $userId");
	
	
	
	
		$_SESSION['users_update_errs']['useraddeds'] = 'User deleted !';
		header('location:'.ruadmin.'home.php?p=user_manage'); exit;			
	
	}

?>