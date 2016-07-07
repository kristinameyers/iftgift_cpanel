<?php
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once("../security.php");
require_once("../inc/function.php");
//echo '<pre>';print_r($_GET);exit;	
	if(isset($_GET['action']) && $_GET['action']=='del_o')
	{
		$Id=$_GET['Id'];
			
			mysql_query("DELETE FROM ".tbl_order_detail." where orderID=".$Id);
			
			mysql_query("DELETE FROM ".tbl_shipping_address." where orderID=".$Id);
			
			mysql_query("DELETE FROM ".tbl_order." where orderID=".$Id);
			
			$_SESSION['msg']='Order deleted successfully';
			header("location:".ruadmin."home.php?p=user_orders");exit;
	}	
	
	
	if(isset($_GET['action']) && $_GET['action']=='del_od')
	{
		$Id=$_GET['Id'];
		$orderId = $_GET['orderId'];	
			mysql_query("DELETE FROM ".tbl_order_detail." where orderdID=".$Id);
			
			$_SESSION['order_view']='Order deleted successfully';
			header("location:".ruadmin."home.php?p=view_order&orderID=".$orderId);exit;
	}		

	if(isset($_GET['order_id']))
	{
		$order_id = $_GET['order_id'];
		$status = $_GET['status'];
		mysql_query("update ".tbl_order." set ostatus = '".$status."' where orderID='".$order_id."'");
		
		$OrderInfo = mysql_fetch_array(mysql_query("select customerID from ".tbl_order." where orderID = '".$order_id."'"));
		
		$CusInfo = mysql_fetch_array(mysql_query("select email from ".tbl_user." where userId = '".$OrderInfo['customerID']."'"));
		
		$OrderdInfo = $db->get_results("select product_id from ".tbl_order_detail." where orderID = '".$order_id."'",ARRAY_A);
		
		/*******************************************START SEND MAIL OF ORDER PROCESS [For User]*****************************************************************/
			if($status == 'shipped') {
			$to = $CusInfo['email'];
			$subject="[iftGift] iftGift Order Processing!";
			$from = "Info@iftgift.com";
			$headers  = 'From: '.$from. "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message	= '<div style="width:630px;border:#c5c4c4 2px solid;  margin:0 auto;background-color:#f6f0fa; font-family:Arial, Helvetica, sans-serif; font-size:12.5px; color:#000;">
  				<div style="border:#ede2f5 thin solid; ">
    				<div style="height:764px;font-size:15px !important; line-height:0.95">
    					<img src="'.ru_resource.'images/header-email-new.png" alt="iftgift" />
    					<div style="padding-left: 13px; padding-top: 15px;">
      						<div style="-moz-border-radius:6px;-webkit-border-radius:6px;background: #fff;margin-top: 20px;border: 1px solid #cccccc;width: 602px;padding-top: 15px;height: 632px;" >';
								foreach($OrderdInfo as $proid)
								{
									$product = mysql_fetch_array(mysql_query("select pro_name,price from ".tbl_product." where proid = '".$proid['product_id']."'"));
								$message	.='<p style="margin-left:10px;"><strong>Product Name</strong> : '.$product['pro_name'].'</p>
									<p style="margin-left:10px;"><strong>Product Price</strong> : $'.$product['price'].'</p>';
								}	
      							$message .='<center><p style="font-weight: bold">Your Order '.ucfirst($status).'.</p>
        									<p></p></center>
      						</div>
      					</div>
    				</div>
  				</div>
  				<center>
      				<p>&nbsp;</p>
      					<table style="color:#726f6f;">
      						<tr>
      							<td><a href="#" style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Home</a></td>
      							<td>|</td>
      							<td><a href="whatisiftgift.php"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">What is <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Gift?</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Schedule of <span style="font-weight:bold;color:#ff69ff">i</span><span style="font-weight:bold;color:#3399cc">f</span><span style="font-weight:bold;color:#ff9900">t</span>Points</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">FAQ</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Contact</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Terms</a></td>
      							<td>|</td>
      							<td><a href="#"  style="text-decoration:none; color: #726f6f;padding-left: 5px;padding-right: 5px;">Privacy</a></td>
     						</tr>
      					</table>
      					<p style="color:#726f6f;">Protected by one or more the following US Patents and Patents Pending: 8,280,825 and 8,589,314.<br />
        				Copyright © 2011, 2012, 2013 Morris Fritz Friedman · All Rights Reserved · iftGift</p>
      					<p style="color:#726f6f;">This message was sent from a notification-only email address that does not accept incoming email. <br />
        				Please do not reply to this message.</p>
      					<p><a style="color: #726f6f;font-weight: bold; text-decoration: none" href="http://www.iftGift.com" target="_blank">www.iftGift.com</a></p>
  				</center>
  				<div style=" height:250px;"></div>
			</div>';
			//echo $message;exit;
			//$mailsent = mail($to,$subject,$message,$headers);
				sendmail_admin($to,  $subject, $message,$headers);	
		}	
		/*******************************************END SEND MAIL OF ORDER PROCESS {For User}*****************************************************************/	
		
		$_SESSION['order_view'] = 'Order Updated Successfully';
	}

?>