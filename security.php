<?php
	if (  $_SESSION['cp_cmd']['type'] != 'a' && $_SESSION['cp_cmd']['type'] != 's' )
	{	
		session_destroy();
		$msg=base64_encode('your session have been expired, Please login!');
		header('location:'.ruadmin.'index.php?msg='.$msg);
	}
	
?>