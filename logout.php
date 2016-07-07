<?php 	
		session_start();
		session_destroy();
		$msg=base64_encode('you have logged out successfully !');
		header('location:index.php?msg='.$msg);
?>