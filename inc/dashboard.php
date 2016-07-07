<?php
		/*$user_qry = mysql_query("SELECT * FROM contact");
		$user_view = mysql_num_rows($user_qry);
		
		$user_qryf = mysql_query("SELECT * FROM contact where status = '1'");
		$user_viewf = mysql_num_rows($user_qryf);
		
		$user_qryp = mysql_query("SELECT * FROM contact where status = '0'");
		$user_viewp = mysql_num_rows($user_qryp);
		
		$order_qry = mysql_query("SELECT * FROM orders where fname !=''");
		$order_view = mysql_num_rows($order_qry);
		
		$order_qryf = mysql_query("SELECT * FROM orders where fname !='' and status = '1'");
		$order_viewf = mysql_num_rows($order_qryf);
		
		$order_qryp = mysql_query("SELECT * FROM orders where fname !='' and status = '0'");
		$order_viewp = mysql_num_rows($order_qryp);*/
		
?>
<h3><a href="home.php">Welcome to iftGift <?php if($_SESSION['cp_cmd']['type'] == 'a') { ?>Admin<?php } else { ?>Staff<?php } ?> Panel</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Dashboard</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
		<?php /*?><fieldset>
		<p><label><strong>Total Orders:</strong></label>&nbsp;&nbsp;<?php  echo $order_view;?></p>
			 <p><label><strong>Total Viewed Orders:</strong></label>&nbsp;&nbsp;<?php echo $order_viewf; ?></p>														
			<p><label><strong>Total Unviewed Orders:</strong></label>&nbsp;&nbsp;<?php echo $order_viewp; ?></p>
			
			<p><label>&nbsp;</label></p>
			
			<p><label><strong>Total Contacts:</strong></label>&nbsp;&nbsp;<?php  echo $user_view;?></p>
			 <p><label><strong>Total Viewed Contacts:</strong></label>&nbsp;&nbsp;<?php echo $user_viewf; ?></p>														
			<p><label><strong>Total Unviewed Contacts:</strong></label>&nbsp;&nbsp;<?php echo $user_viewp; ?></p>
		</fieldset><?php */?>
	</div>
</div>