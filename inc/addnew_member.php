<h3><a href="<?php echo ruadmin; ?>home.php?p=product_manage">Staff</a> &raquo; <a href="#" class="active">Add New Staff Member</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Add New Staff Member</h3>
		<div class="clear"></div>
	</div>
	
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['biz_stf_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_stf_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } ?>
	<div id="main">
		<form  method="post" action="<?php echo ruadmin; ?>process/process_member.php">
			<fieldset>
				<input name="userId" id="userId" type="hidden"  value="<?php echo $_SESSION['cp_cmd']['userId']; ?>"/>
				<p><label>*First Name:</label><input name="first_name" id="first_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_stf']['first_name']; ?>"/></p>
				
				<p><label>*Last Name:</label><input name="last_name" id="last_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_stf']['last_name']; ?>"/></p>
				
				<p><label>*Userame:</label><input name="username" id="username" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_stf']['username']; ?>"/></p>
				
				<p><label>*Email:</label><input name="email" id="email" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_stf']['email']; ?>"/></p>
				
				<p><label>*Password:</label><input name="password" id="password" type="password" class="text-input small-input"  value="<?php echo $_SESSION['biz_stf']['password']; ?>"/></p>
				
				<p><label>*Confirm Password:</label><input name="cpassword" id="cpassword" type="password" class="text-input small-input"  value="<?php echo $_SESSION['biz_stf']['cpassword']; ?>"/></p>
								
				<p><label>*Select Privileges</label>
				<input type="checkbox" name="privilege[]" value="1" />Category Management<br />
				<input type="checkbox" name="privilege[]" value="2" />Product Management<br />
				<input type="checkbox" name="privilege[]" value="3" />Ocassion Category/Group Management<br />
				<input type="checkbox" name="privilege[]" value="4" />Importer<br />
				<input type="checkbox" name="privilege[]" value="5" />Order Management<br />
				<input type="checkbox" name="privilege[]" value="6" />Withdraw Management
				</p>
				
				<p><label>Status:</label>
				<select name="status" id="status">
				<option value="1"<?php if($_SESSION['biz_stf']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0"<?php if($_SESSION['biz_stf']['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>
				</p>
				
				</p>
				<p style="width:100%">
				<input type="submit" class="button" value="Save" name="SaveStaff" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php
unset($_SESSION['biz_stf_err']);
unset($_SESSION['biz_stf']);
?>