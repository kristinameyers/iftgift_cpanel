<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once("../security.php");
require_once ('../inc/functii.php');

//echo '<pre>';print_r($_POST);exit;
if ( isset ($_POST['SaveStaff'])){
	
	unset($_SESSION['biz_stf_err']);
	unset($_SESSION['biz_stf']);
	
	foreach ($_POST as $k => $v )
	{
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_stf'][$k]=$v;
	
	}
		$flgs = false;
		//-----------------first name validation--------------------//
	   if($first_name == '')
		{
		
			$_SESSION['biz_stf_err']['first_name'] = 'Please enter first name';
			$flgs = true;
		}
		//----------------------last name validation-----------------//
		if($last_name == '')
		{
			$_SESSION['biz_stf_err']['last_name'] = 'Please enter last name';
			$flgs = true;
		}
		//----------------------username validation-----------------//
		if($username == '')
		{
			$_SESSION['biz_stf_err']['username'] = 'Please enter username';
			$flgs = true;
		} elseif($username!=''){
	
			    $sqlcount = "select count(*) as ecount from ".tbl_user." where username like '$username' and type = 's'";
				$arrcount=mysql_query($sqlcount);
				$rowData =mysql_fetch_array($arrcount);
				if($rowData['ecount']> 0)
				{
					$_SESSION['biz_stf_err']['username'] = 'This username already exists. Try another username!';
					$flgs = true;
	
				}
		}
		//---------------------------Email validation-----------------------//
		if(!$email)
		{
			$_SESSION['biz_stf_err']['email'] = $_ERR['register']['email'];
			$flgs = true;
		
		}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['biz_stf_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}else{
	
			     $sqlcount = "select count(*) as ecount from ".tbl_user." where email like '$email' and type = 's'";
				$arrcount=mysql_query($sqlcount);
				$rowData =mysql_fetch_array($arrcount);
				if($rowData['ecount']> 0)
				{
					$_SESSION['biz_stf_err']['email'] = $_ERR['register']['emaile'];
					$flgs = true;
	
				}
			}
	
		}
		
		//--------------------password validation---------------------//
		
		if($password == ''){
			    $_SESSION['biz_stf_err']['password'] = 'Please enter password';
				$flgs = true;
		}
		
		if($password != '' & $cpassword!=''){
			if(verifypassword($password))
			{    $_SESSION['biz_stf_err']['password'] = $_ERR['register']['passg'];
				$flgs = true;
			}
		
		//----------------- Check if the password matched---------------//
			
			if($password != $cpassword)
			{
				$_SESSION['biz_stf_err']['cpassword'] = $_ERR['register']['passc'];
				$flgs = true;
			}
			$passwrd = " password ='".md5($password)."',";
		}
		
		//-----------------Privileage validation--------------------//
	   /*if($_POST['privilege'] != 'Array')
		{
		
			$_SESSION['biz_stf_err']['privilege'] = 'Please select privileges for staff member';
			$flgs = true;
		}*/

	  if($flgs){
		header('location:'.ruadmin.'home.php?p=addnew_member'); exit;
	  }else{

		foreach($_POST['privilege'] as $pre)
		{
			$privilege .= $pre.',';	
		}
		$privileges = rtrim($privilege,',');
	
				$upd_user ="Insert into ".tbl_user." set 	first_name 	='$first_name',
												last_name	='$last_name',
												username	='$username',
												email		='$email',
												".$passwrd."
												status 		='$status',
												type		='s',
												privilege	='$privileges',
												dated 	=now()";
										
				
				$db->query($upd_user);
				unset($_SESSION['biz_stf_err']);
				unset($_SESSION['biz_stf']);
						
			$_SESSION['biz_stf_err']['useradded'] = 'Staff Member Added Successfully!';
				header('location:'.ruadmin.'home.php?p=addnew_member');
			exit;
	  }
}


/////////////////////////////////////////Update User///////////////////////////////////////////////////////

if ( isset ($_POST['UpdateStaff'])){
	
	unset($_SESSION['member_update_err']);
	unset($_SESSION['members_update']);
	
	foreach ($_POST as $k => $v )
	{
		$$k =  addslashes(trim($v ));
		$_SESSION['members_update'][$k]=$v;
	
	}
		$flgs = false;
		
		//-----------------first name validation--------------------//
	   if($first_name == '')
		{
		
			$_SESSION['member_update_err']['first_name'] = 'Please enter first name';
			$flgs = true;
		}
		//----------------------last name validation-----------------//
		if($last_name == '')
		{
			$_SESSION['member_update_err']['last_name'] = 'Please enter last name';
			$flgs = true;
		}
		//----------------------username validation-----------------//
		if($username == '')
		{
			$_SESSION['member_update_err']['username'] = 'Please enter username';
			$flgs = true;
		} elseif($username!=''){
	
			    $sqlcount = "select count(*) as ecount from ".tbl_user." where username like '$username' and type = 's' and userId != $userId";
				$arrcount=mysql_query($sqlcount);
				$rowData =mysql_fetch_array($arrcount);
				if($rowData['ecount']> 0)
				{
					$_SESSION['member_update_err']['username'] = 'This username already exists. Try another username!';
					$flgs = true;
	
				}
		}
//---------------------------Email validation-----------------------//
		if(!$email)
		{
			$_SESSION['member_update_err']['email'] = $_ERR['register']['email'];
			$flgs = true;
		
		}elseif($email!=''){
			
			if (vpemail($email )){
			
				$_SESSION['member_update_err']['email'] = $_ERR['register']['emailg'];
				$flgs = true;
			
			}else{
	
			    $sqlcount = "select count(*) as ecount from ".tbl_user." where email like '$email' and type = 's' and userId != $userId ";
				$arrcount=mysql_query($sqlcount);
				$rowData =mysql_fetch_array($arrcount);
				if($rowData['ecount']> 0)
				{
					$_SESSION['member_update_err']['email'] = $_ERR['register']['emaile'];
					$flgs = true;
	
				}
			}
	
		}

//--------------------password validation---------------------//
		
		if($password != '' & $cpassword!=''){
			if(verifypassword($password))
			{    $_SESSION['member_update_err']['password'] = $_ERR['register']['passg'];
				$flgs = true;
			}
		
//----------------- Check if the password matched---------------//
			
			if($password != $cpassword)
			{
				$_SESSION['member_update_err']['cpassword'] = $_ERR['register']['passc'];
				$flgs = true;
			}
			$passwrd = " password ='".md5($password)."',";
		}

	  if($flgs){
		header('location:'.ruadmin.'home.php?p=member_edit'); exit;
	  }else{
			
			foreach($_POST['privilege'] as $pre)
		{
			$privilege .= $pre.',';	
		}
		$privileges = rtrim($privilege,',');
		
				$upd_user ="Update ".tbl_user." set 	first_name 	='$first_name',
												last_name	='$last_name',
												username	='$username',
												status = '$status',
												email		='$email',
												".$passwrd."
												type		='s',
												privilege	='$privileges',
												dated 	=now()
										where   userId 		=$userId";
										
				
				$db->query($upd_user);
				unset($_SESSION['member_update_err']);
				unset($_SESSION['users_update']);
						
			$_SESSION['member_update_errs']['useraddeds'] = 'Staff Member Updated Successfully!';
				header('location:'.ruadmin.'home.php?p=staff_manage');
			exit;
	  }
}


if ( isset ($_GET['action'])  and  ($_GET['action']=='delluser'))
{
			
	$userId  =$_GET['userId'];

	$biz_Sql = mysql_query("delete from ".tbl_user." where userId  = $userId and type = 's' ");
	
		$_SESSION['member_update_errs']['useraddeds'] = 'Staff Member deleted !';
		header('location:'.ruadmin.'home.php?p=staff_manage'); exit;			
	
	} 
?>