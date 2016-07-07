<?php
require_once("../../connect/connect.php");
require_once("../security.php");

	
	if(isset($_GET['action']) && $_GET['action']=='del_c')
	{
		$Id=$_GET['Id'];
		
		$sql = mysql_query("DELETE FROM contact where Id=".$Id);
			
			$_SESSION['msg']='Contact deleted successfully';
			header("location:".ruadmin."home.php?p=contact_emails");exit;

	}
	
	
	if(isset($_GET['action']) && $_GET['action']=='del_o')
	{
		$Id=$_GET['Id'];
		
			mysql_query("DELETE FROM orders where Id=".$Id);
			
			mysql_query("DELETE FROM order_detail where oId=".$Id);
			
			$_SESSION['msg']='Order deleted successfully';
			header("location:".ruadmin."home.php?p=user_orders");exit;
	}		


?>