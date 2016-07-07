<h3><a href="<?php echo $ruadmin; ?>home.php?p=banner_manage">Banner</a> &raquo; <a href="#" class="active">Add Banner </a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Add New Banner</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['error_image']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['error_image'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['error_image']); ?>
	<div id="main">
		<form  method="post" action="<?php echo $ruadmin; ?>process/process_banner.php" enctype="multipart/form-data">
		<input type="hidden" name="banner_id" id="banner_id" value="<?php echo $_GET['id']; ?>" />
			<fieldset>
			  <p><label>*Url:</label><input name="url" id="url" type="text" class="text-input small-input"  value="<?php echo $_SESSION['add_image']['url']; ?>"/></p>

				 <p><label> Upload Image :</label>
				<input name="image" id="image" type="file" class="text-input small-input"/>&nbsp;(image size 603 X 360 ) </p> 
				
				
					<p><label>Status:</label>Active<input type="radio" name="status" value="1" />
									Inactive</strong><input type="radio" name="status" value="0" />
			</p>
				
				
				<p style="width:100%"  >
				<input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;" name="Add_banner" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php unset($_SESSION['add_image']);?>