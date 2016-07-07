<?php
	$type = $_GET['type'];
	
	$type = ($type)?$type:"signup";
	
	$where = "type='".$type."'";
	$qry="select * from  ".tbl_emails." where ".$where;
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
	window.location = "<?php echo $ruadmin; ?>home.php?p=emails_alert&type="+type;
 }
</script>
<style>
#main-content tbody tr td { text-align:left;}
</style>
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
				<?php echo $_SESSION['msgText'];
				 unset($_SESSION['msgText']);
				?>
			</div>
		</div>	
	<?php } ?>	
<form   method="post" action="process/process_email_templts.php">
<input type="hidden" name="type" value="<?php echo $type; ?>">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
		<td width="131" >Set email to:</td>
		<td width="500">
		    <select class="normal" name="type" id="type" onchange="mailcontent();">
			<?php /*?><option <?php if($type == "contact"){ ?> selected="selected" <?php } ?> value="contact">Contact Us (user)</option>
			<option <?php if($type == "contact_admin"){ ?> selected="selected" <?php } ?> value="contact_admin">Contact Us (admin)</option><?php */?>
			<option <?php if($type == "signup"){ ?> selected="selected" <?php } ?> value="signup">Sign up</option>
			<?php /*?><option <?php if($type == "requestcalim"){ ?> selected="selected" <?php } ?> value="requestcalim">Claim Request User</option>
			<option <?php if($type == "verifyclaim"){ ?> selected="selected" <?php } ?> value="verifyclaim">Claim Verification</option>
			<option <?php if($type == "requestcalimadmin"){ ?> selected="selected" <?php } ?> value="requestcalimadmin">Claim Request Admin</option>
			<option <?php if($type == "rejectcalim"){ ?> selected="selected" <?php } ?> value="rejectcalim">Claim Reject</option>
			<option <?php if($type == "acceptcalim"){ ?> selected="selected" <?php } ?> value="acceptcalim">Claim Accept</option>
			<option <?php if($type == "expirycalim_cp"){ ?> selected="selected" <?php } ?> value="expirycalim_cp">Claim Request Period Expiry</option>
			<option <?php if($type == "expirycalim_pr"){ ?> selected="selected" <?php } ?> value="expirycalim_pr">Claim Request Accept Period Expiry</option>
			<option <?php if($type == "accesslog_business"){ ?> selected="selected" <?php } ?> value="accesslog_business">Profile Access Log Business</option>
			<option <?php if($type == "accesslog_business_claim"){ ?> selected="selected" <?php } ?> value="accesslog_business_claim">Profile Access Log Business Claim            </option><?php */?>
			<option <?php if($type == "forgotpassword"){ ?> selected="selected" <?php } ?> value="forgotpassword">Forgot Password</option>
			<?php /*?><option <?php if($type == "report_error"){ ?> selected="selected" <?php } ?> value="report_error">Report An Error</option><?php */?>
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
			<td colspan="2"><input type="text" name="subject"  value="<?php echo $subject; ?>" size="92" class="text-input"></td>
			</tr>
			
			<tr>
			<td  valign="top">Email&nbsp;Body:</td>
			<td colspan="2">
			</td>
			</tr>
			
			<tr> 
			<td colspan="3">
			<span class="msg"> {{Firstname}}, {{LastName}}, {{BusinessName}}, {{Email}}, {{Password}}</span>
			<?php		
			include("FCKeditor/fckeditor.php");		
			$oFCKeditor = new FCKeditor('txtData') ;
			$oFCKeditor->BasePath = 'FCKeditor/';
			$oFCKeditor->Value = nl2br($htmlData);
			$oFCKeditor->Create() ;
			?>
			</td>
			</tr>
			
			<tr>
			<td colspan="3" align="right"><input type="submit" class="button" name="SaveEmail" value="Save"></td>
		  </tr>
        </table>
      </form>
    </div>
 </div>	       

