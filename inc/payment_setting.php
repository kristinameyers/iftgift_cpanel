<?php
	$settingID = '1';
	$setting_sql    = "SELECT * FROM ".tbl_payment_setting." where settingID =$settingID";
	$setting_rs = mysql_query($setting_sql) or die (mysql_error());
	if ( mysql_num_rows($setting_rs) ==0 ){
		
		header('location:'.ruadmin.'home.php');
		exit;
	}
	
	if ( !isset ($_SESSION['payment_setting']) or ($_SESSION['payment_setting']['settingID'] != $settingID ) )
	{
		$setting_row = mysql_fetch_array($setting_rs);
		$_SESSION['payment_setting'] =$setting_row;
	}
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Payment Setting</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Payment Setting</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
	  <?php if ( isset ($_SESSION['payment_setting_err']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
				<?php foreach ($_SESSION['payment_setting_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
				</div>
			</div>	
	  <?php } unset ($_SESSION['payment_setting_err']);?>	
	  <div id="main">
		<form action="<?php echo ruadmin; ?>process/process_paymentsetting.php" method="post">
			<fieldset>
		  		<p><input type="radio" name="setting" id="setting" value="1"<?php if($_SESSION['payment_setting']['payment_option'] == '1') echo 'checked="checked"'; ?> />On</p>
		  		<p><input type="radio" name="setting" id="setting" value="0"<?php if($_SESSION['payment_setting']['payment_option'] == '0') echo 'checked="checked"'; ?> />Off</p>
	 			<input type="submit" class="button" name="payment_setting" value="Update" />
			</fieldset>
		</form>
	</div>
	</div>
</div>	
