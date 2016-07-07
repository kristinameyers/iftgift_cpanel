<?php 
$banner_id = $_GET['banner_id'];
$qry_image = "SELECT * FROM banner where id ='".$banner_id."'";
$rs_image =mysql_query($qry_image);
$row_image = mysql_fetch_array($rs_image);
if(!isset($_SESSION['image_edit']) && $_SESSION['image_edit']['banner_id']!= $banner_id){

	
	$_SESSION['image_edit']=$row_image;
}
//		echo '<pre>';print_r($_SESSION['news_edit']);exit;

?>

<h3><a href="<?php echo $ruadmin; ?>home.php?p=banner_manage">Manage Banner</a> &raquo; <a href="#" class="active">Update Banner</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Update Banner</h3>
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
		<input name="banner_id" type="hidden" value="<?php echo $banner_id ?>"/>
		<input name="oldimage" type="hidden" value="<?php echo $row_image['image'] ?>"/>
			<fieldset>

			<p>
			 		<label>Url:</label>
			 	<input style="margin:0 10px 0 0" name="url" id="url" value="<?php echo $_SESSION['image_edit']['url'] ?>" type="text" class="text-input small-input" />
				</p>
			

			
			<?php if($row_image['image']!=''){ ?>
 				<p style="width:100%">
				<img width="120px" height="70px" style=" border:1px solid #ccc; padding:3px;" src="<?php echo $ru ?>media/banner/<?php echo $row_image['image'] ?>"></p>
				<?php }else{?>
				<p style="width:100%">
				<img width="120px" height="70px" style=" border:1px solid #ccc; padding:3px;" src="<?php echo $ru ?>media/banner/no_img.gif"></p>
				<?php } ?>
			
				 <p><label> Upload Image :</label>
				<input name="image" id="image" type="file" class="text-input small-input"/>&nbsp;(image size 603 X 360 ) </p> 
				
				
					<p><label>Status:</label>Active<input type="radio" name="status" value="1" <?php if($_SESSION['image_edit']['status']=='1'){ echo "checked='checked'";}else{ echo "checked='checked'";}?> />
									Inactive</strong><input type="radio" name="status" value="0" <?php if($_SESSION['image_edit']['status']=='0'){ echo "checked='checked'";}?> />
			</p>
				
				<p style="width:100%"  >
				<input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;" name="Update_banner" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php 
unset($_SESSION['image_edit']);
unset($_SESSION['news_edit_err']);


?>