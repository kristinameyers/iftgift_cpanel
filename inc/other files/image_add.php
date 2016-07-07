<?php

   if( isset ( $_POST['addimage'] ))
	{	
	include ("upload.php");
		unset($_SESSION['image_err']);
		unset($_SESSION['image_update']);
		foreach ($_POST as $k => $v )
		{
			$$k =  addslashes(trim($v ));
			 $_SESSION['image_update'][$k]=$v; 
		}
	if ( isset($_FILES['photo']['tmp_name'])) 
			{ 
				$rewardphoto ='';			
				$upload_dir = $rootpath.'media/carimages/';
				chmod($upload_dir,0777);	

				$ext= array ('gif','jpg','jpeg','png','bmp');			

			    $file_type=$_FILES['photo']['type'];   			
				if(!empty($_FILES['photo']['name']))
				{ 
					$upload = new upload('photo', $upload_dir, '777', $ext);
					if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
					{ 
						$rwdphoto=$upload->filename;	
						$rewardphoto =" photo ='".$rwdphoto."', ";			
					}else{
						$_SESSION["image_err"]["photo"] = "Error: Upload an Image file.";
					}	
				}
			}
			
   $sql= "insert into norio_images set $rewardphoto 	title ='".$title."' " ;

			if($db->query($sql))
			{
				$_SESSION['image_err'] = "Image updated successfuly "; 
				header('location:home.php?p=image_add');
				exit;
	
			}
	}

?>

<h3><a href="<?php echo ruadmin; ?>home.php?p=user_manage">Users</a> &raquo; <a href="#" class="active">Add New User</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Add New User</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['user_reg_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['user_reg_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['user_reg_err']); ?>
	<div id="main">
		<form  method="post" action="home.php?p=image_add"  enctype="multipart/form-data">
			<fieldset>
				<fieldset>
				<p><h3><font color="#A90000">Image:</font></h3></p>
				<p><label>Title:</label><input name="title" id="title" type="text" class="text-input small-input"  value="<?php echo $setting_rs['title']; ?>"/></p>
				<p><label>Photo:&nbsp;(size should be 400x200px)</label><input name="photo" id="photo" type="file" class="text-input small-input"  value=""/></p>
				<p><img src="<?php echo ruadmin;?>inc/image/<?php echo $setting_rs['photo']; ?>" border="0" width="400" height="200" /></p>

				<p style="width:100%"  >
				<input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;" name="addimage" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>