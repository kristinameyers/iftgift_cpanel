<?php 
	$userId = $_GET['userId'];
	$User_sql    = "SELECT * FROM ".tbl_user." where userId =$userId";
	$User_rs = mysql_query($User_sql) or die (mysql_error());
	if ( mysql_num_rows($User_rs) ==0 ){
		
		header('location:'.ruadmin.'home.php');
		exit;
	}
	
	if ( !isset ($_SESSION['user_update']) or ($_SESSION['user_update']['userId'] != $userId ) )
	{
		$User_row = mysql_fetch_array($User_rs);
		$_SESSION['user_update'] =$User_row;
		$_SESSION['user_update']['cpassword'] =$_SESSION['user_update']['password'];
	}

?>
<h3><a href="home.php">Home</a> &raquo; <a href="#" class="active">Edit My Profile</a></h3>
	<div class="content-box">
		<div class="content-box-header">
		<h3>My Profile settings</h3>
		<div class="clear"></div>
		</div>
	<div class="content-box-content">                    
	<?php if ( isset($_SESSION['user_update_err']) ) { ?>
		<div class="notification error png_bg">
		<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
		<div>
		<?php foreach ($_SESSION['user_update_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
		</div>
		</div>
	<?php }
	unset ($_SESSION['user_update_err']); ?>
		<div id="main">
			<form  method="post" action="process/process_user.php">
				<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION['cp_cmd']['userId'];?>"  />
				<input type="hidden" name="type" id="type" value="<?php echo $_SESSION['cp_cmd']['type'];?>"  />
				<fieldset>
				<p><label>First Name:&nbsp;&nbsp;</label><input name="first_name" id="first_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['user_update']['first_name']; ?>"/></p>
				<p><label>Last Name:</label><input name="last_name" id="last_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['user_update']['last_name']; ?>"/></p>
				<p><label>Password:</label><input name="password" id="password" type="password" class="text-input small-input" value="" /></p>
				<p><label>Confirm Password:</label><input name="cpassword" id="cpassword" type="password" class="text-input small-input" value="" /></p>
				<p><label>Email:</label><input name="email" id="email" type="text" class="text-input small-input" value="<?php echo $_SESSION['user_update']['email']; ?>" /></p>
				<p style="width:100%">
				<input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;" name="UpdateMember" id="UpdateMember" />
				</p>
				</fieldset>
			</form>
		</div>
	</div>
	</div>	     
        
        