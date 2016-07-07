<?php
	$type = $_GET['type'];
	$type = ($type)?$type:"signup";
	$where = "type='".$type."'";
	$qry="select * from emails where ".$where;
	$rs=mysql_query($qry);
	$row =mysql_fetch_array($rs);
	$adminName=$row['adminname'];
	$toadmin=$row['toadmin'];
	$touser=$row['touser'];
	$subject=$row['subject'];
	$htmlData=$row['body'];
	
	$htmlData = stripslashes($htmlData);
?>
<script language="javascript" type="text/javascript">
function mailcontent()
{
	var type = document.getElementById('type').value;
	window.location = "<?php echo ruadmin; ?>home.php?p=emails_alert&type="+type;
}
</script>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Email Templates Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Email Templates Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
		<?php if ( isset ($_SESSION['msgText']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php echo  $_SESSION['msgText']; unset($_SESSION['msgText']); ?>
			</div>
		</div>	
	<?php } ?>	
<form   method="post" action="inc/savemailalert.php">
<input type="hidden" name="savepage" value="<?php echo $type; ?>">
<table border="0" width="100%" cellpadding="0" cellspacing="0">

    <tr>
		<td width="131" >Set email to:</td>
		<td width="500">
		<select class="normal" name="type" id="type" onchange="mailcontent();">
            <option <?php if($type == "contact"){ ?> selected="selected" <?php } ?> value="contact">Contact Us</option>
			<option <?php if($type == "user_info"){ ?> selected="selected" <?php } ?> value="user_info">Cart Detail</option>
			<option <?php if($type == "reset_password"){ ?> selected="selected" <?php } ?> value="reset_password">Forgot Password</option>
            <option <?php if($type == "cart_detail_abroad"){ ?> selected="selected" <?php } ?> value="cart_detail_abroad">Cart Detail Abroad</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Admin Name:</td>
		<td colspan="2"><input type="text" name="adminname" value="<?php echo $adminName; ?>" size="40" class="text-input">&nbsp;&nbsp;<span class="supporting">The admin name which display on user's email</span></td>
	</tr>
	<tr>
		<td>Email to Admin:</td>
		<td colspan="2"><input type="text" name="toadmin" value="<?php echo $toadmin; ?>" size="40" class="text-input">&nbsp;&nbsp;<span class="supporting">Where admin receive emails from users</span></td>
	</tr>
	<tr>
		<td>Email to User:</td>
		<td colspan="2"><input type="text" name="touser" value="<?php echo $touser; ?>" size="40" class="text-input">
		  &nbsp;&nbsp;<span class="supporting">The emails which user get email from </span></td>
	</tr>
	<tr>
		<td>Email&nbsp;Subject:</td>
		<td colspan="2"><input type="text" name="txtSubject" value="<?php echo $subject; ?>" size="92" class="text-input"></td>
	</tr>
	<tr>
		<td  valign="top">Email&nbsp;Body:</td>
		<td colspan="2">
		</td>
	</tr>

	<tr>
		<td colspan="3">
		<span class="msg"> {{Username}}, {{Email}}, {{Password}}</span>
		<textarea  name="txtData" cols="70" rows="30"><?php echo $htmlData; ?></textarea>	
		</td>
	</tr>
	
	<tr>
		<td colspan="3" align="right"><input type="submit" class="button" name="SaveTextData" value="Save"></td>
	    
	</tr>
</table>
</form>
	</div>
</div>	       