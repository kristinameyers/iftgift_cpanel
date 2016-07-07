<?php
	ob_start();	
	include ("../connect/connect.php");		
	include ("../config/config.php");			
	
	if ( isset ($_POST['login'])) 
	{	
		if (empty($_POST['name']) || empty($_POST['password']))
		{
			$msg=base64_encode('Please enter User and Password to continue.');
			header("location:".ruadmin."index.php?msg=$msg");exit;
		}
		/*if (empty($_POST['pincode']))
		{
			$msg=base64_encode('Please enter Security Code to continue.');
			header("location:".ruadmin."index.php?msg=$msg");exit;
		}elseif (strtolower($_POST['pincode']) != strtolower($_SESSION['security_code']))
		{
			$msg=base64_encode('Entered Security Code is Invalid.');
			header("location:".ruadmin."index.php?msg=$msg");exit;
		}*/
		$name =  addslashes(trim($_POST['name']));
		$password =  addslashes(trim($_POST['password']));
		
		$qry="SELECT userId,first_name,last_name,email,username,type ,status,	dated  FROM ".tbl_user." where ( email  =  '".$name."' or  username = '".$name."') and password='".md5($password)."' ";
		
		$rs = @mysql_query($qry);
		if ( @mysql_num_rows($rs)> 0 ) 
		{
			
			$rowAdmin = mysql_fetch_array($rs);
			if( $rowAdmin['status'] != '1' ){
				
				$msg=base64_encode('Account disabled !');
				header("location:".ruadmin."index.php?msg=$msg");exit;
			}
			
			$_SESSION['cp_cmd'] = $rowAdmin;
			//$upsql = "update user set loginlogout=now() where  userId =".$_SESSION['cp_cmd']['userId']." ";
			//mysql_query($upsql)or die (mysql_error());
			$_SESSION['adminLogincoupon']='True';
			header("location:".ruadmin."home.php");exit;

		}else{
		
			$msg=base64_encode('Invalid user name or password !');
			header("location:".ruadmin."index.php?msg=$msg");exit;
		}
	}else{
		header("location:".ruadmin."index.php");exit;
	}
?>