<?php 
if ( isset($_GET['userId']) and $_GET['userId'] != '')
{ 
	
	$userId = $_GET['userId'];
	$User_sql    = "SELECT * FROM ".tbl_user." where userId =$userId and type = 's'";
	$User_rs = mysql_query($User_sql) or die (mysql_error());
	if ( mysql_num_rows($User_rs) ==0 ){
		
		header('location:'.ruadmin.'home.php');
		exit;
	}
	
	if ( !isset ($_SESSION['members_update']) or ($_SESSION['member_update']['userId'] != $userId ) )
	{
		$User_row = mysql_fetch_array($User_rs);
		$_SESSION['members_update'] =$User_row;
		$_SESSION['members_update']['cpassword'] =$_SESSION['member_update']['password'];
	}
	
}
?>
<h3><a href="<?php echo ruadmin; ?>home.php?p=product_manage">Staff</a> &raquo; <a href="#" class="active">Edit Staff Member</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Edit Staff Member</h3>
		<div class="clear"></div>
	</div>
	
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['member_update_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['member_update_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } ?>
	<div id="main">
		<form  method="post" action="<?php echo ruadmin; ?>process/process_member.php">
			<fieldset>
				<input name="userId" id="userId" type="hidden"  value="<?php echo $userId ?>"/>
				<p><label>*First Name:</label><input name="first_name" id="first_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['members_update']['first_name']; ?>"/></p>
				
				<p><label>*Last Name:</label><input name="last_name" id="last_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['members_update']['last_name']; ?>"/></p>
				
				<p><label>*Userame:</label><input name="username" id="username" type="text" class="text-input small-input"  value="<?php echo $_SESSION['members_update']['username']; ?>"/></p>
				
				<p><label>*Email:</label><input name="email" id="email" type="text" class="text-input small-input"  value="<?php echo $_SESSION['members_update']['email']; ?>"/></p>
				
				<p><label>*Password:</label><input name="password" id="password" type="password" class="text-input small-input"  value=""/></p>
				
				<p><label>*Confirm Password:</label><input name="cpassword" id="cpassword" type="password" class="text-input small-input"  value=""/></p>
								
				<p><label>*Select Privileges</label>
				<?php
				$privilege_staff = array(
    								"Category" => "1",
    								"Product" => "2",
									"Ocassion Category/Group" => "3",
									"Importer" => "4",
									"Order"	=> "5",
									"Withdraw"	=>	"6",
									);
				$privilege = explode(',',$_SESSION['members_update']['privilege']);					
				foreach($privilege_staff as $key=>$val) { ?>
					<input type="checkbox" name="privilege[]" value="<?php echo $val ?>" <?php if(in_array($val,$privilege)) echo 'checked="checked"'; ?>/><?php echo $key; ?> <?php if($key == 'Importer') {} else {?>Management<?php } ?><br />
				<?php }	?>
				</p>
				<p><label>Status:</label>
				<select name="status" id="status">
				<option value="1"<?php if($_SESSION['members_update']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0"<?php if($_SESSION['members_update']['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>
				</p>
				</p>
				<p style="width:100%">
				<input type="submit" class="button" value="Update" name="UpdateStaff" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php
unset($_SESSION['member_update_err']);
unset($_SESSION['members_update']);
?>