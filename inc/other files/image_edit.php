<?php 
if ( isset($_GET['userId']) and $_GET['userId'] != '')
{ 
	
	$userId = $_GET['userId'];
	$User_sql    = "SELECT * FROM user where userId =$userId";
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
	
}
?>
<?php 
	if($_SESSION['cp_cmd']['userId'] != $userId ) $addnew = ' class="active" ';else $myprofile = ' class="active" ';					
?>
<?php 
if($_SESSION['cp_cmd']['userId'] != $userId ) 
{ ?> 
	<h3><a href="<?php echo ruadmin; ?>home.php?p=user_manage">Users</a> &raquo; <a href="#" class="active">Edit User Profile</a></h3> 
<?php }else{?>
	<h3><a href="<?php echo ruadmin; ?>home.php?p=user_manage">MyInfo</a> &raquo; <a href="#" class="active">Edit User Profile</a></h3>
<?php } ?>
<div class="content-box">
	<div class="content-box-header">
	<?php if($_SESSION['cp_cmd']['userId'] != $userId ) { ?> 
		<h3>Edit User Profile</h3> 
	<?php }else{?>
		<h3>Edit User Profile</h3>
	<?php } ?>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">                    

			<?php if ( isset ($_SESSION['user_update_err']) ) {?>
					<div class="notification error png_bg">
						<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
						<div>
							<?php foreach ($_SESSION['user_update_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
						</div>
					</div>	
			<?php } unset ($_SESSION['user_update_err']);  ?>					
				
                <div id="main">
                
                	<form  method="post" action="process/process_user.php">
                    <input type="hidden" name="userId" id="userId" value="<?php echo $userId ?>"  /> 
                    	<fieldset>
							<p><h3><font color="#A90000">Image:</font></h3></p>
							<p><label>Title:</label><input name="title" id="title" type="text" class="text-input small-input"  value="<?php echo $setting_rs['title']; ?>"/></p>
							<p><label>Photo:&nbsp;(size should be 400x200px)</label><input name="photo" id="photo" type="file" class="text-input small-input"  value=""/></p>
							<p><img src="<?php echo ruadmin;?>inc/image/<?php echo $setting_rs['photo']; ?>" border="0" width="400" height="200" /></p>

							<p style="width:100%">
                            <input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;" name="UpdateMember" id="UpdateMember" />
                            </p>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>	     
