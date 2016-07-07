<?php 
if ( isset($_GET['userId']) and $_GET['userId'] != '')
{ 
	
	$userId = $_GET['userId'];
	$User_sql    = "SELECT * FROM ".tbl_user." where userId =$userId";
	$User_rs = mysql_query($User_sql) or die (mysql_error());
	if ( mysql_num_rows($User_rs) ==0 ){
		
		header('location:'.ruadmin.'home.php');
		exit;
	}
	
	if ( !isset ($_SESSION['users_update']) or ($_SESSION['user_update']['userId'] != $userId ) )
	{
		$User_row = mysql_fetch_array($User_rs);
		$_SESSION['users_update'] =$User_row;
		$_SESSION['users_update']['cpassword'] =$_SESSION['user_update']['password'];
	}
	
}
?>
	<h3><a href="<?php echo ruadmin; ?>home.php?p=user_manage">Users</a> &raquo; <a href="#" class="active">Edit User Profile</a></h3> 
<div class="content-box">
	<div class="content-box-header">
		<h3>Edit User Profile</h3> 
		<div class="clear"></div>
	</div>
	<div class="content-box-content">                    

			<?php if ( isset ($_SESSION['users_update_err']) ) {?>
					<div class="notification error png_bg">
						<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
						<div>
							<?php foreach ($_SESSION['users_update_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
						</div>
					</div>	
			<?php } unset ($_SESSION['users_update_err']);  ?>					
				
                <div id="main">
                
                	<form  method="post" action="process/process_user.php">
                    <input type="hidden" name="userId" id="userId" value="<?php echo $userId ?>"  /> 
                    	<fieldset>
							<p><label>First Name:&nbsp;&nbsp;</label><input name="first_name" id="first_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['users_update']['first_name']; ?>"/></p>
							<p><label>Last Name:</label><input name="last_name" id="last_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['users_update']['last_name']; ?>"/></p>
							<p><label>Password:</label><input name="password" id="password" type="password" class="text-input small-input" value="" /></p>
							<p><label>Confirm Password:</label><input name="cpassword" id="cpassword" type="password" class="text-input small-input" value="" /></p>
							<p><label>Email:</label><input name="email" id="email" type="text" class="text-input small-input" value="<?php echo $_SESSION['users_update']['email']; ?>" /></p>		
                     	
						    <p  style="width:290px;"><label>Status:</label>
                            <select name="status" id="status">
                               	<option value="1" <?php if( $_SESSION['users_update']['status'] == '1'){ ?> selected="selected" <?php } ?>>Active</option>
                            	<option value="-1" <?php if( $_SESSION['users_update']['status'] == '-1'){ ?> selected="selected" <?php } ?>>Pending</option>
                            	<option value="0" <?php if( $_SESSION['users_update']['status'] == '0'){ ?> selected="selected" <?php } ?>>Inactive</option>								
                            </select>
                            </p>                  
                        	
							<p style="width:100%">
                            <input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;" name="UpdateUser" id="UpdateUser" />
                            </p>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>	     
