<h3><a href="<?php echo ruadmin; ?>home.php?p=product_manage">Category</a> &raquo; <a href="#" class="active">Add New Category</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Add New Category</h3>
		<div class="clear"></div>
	</div>
	
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['biz_cat_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_cat_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_cat_err']); ?>
	<div id="main">
		<form  method="post" action="<?php echo ruadmin; ?>process/process_category.php">
			<fieldset>
				
				<p><label>*Category Name:</label><input name="cat_name" id="cat_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_cat']['cat_name']; ?>"/></p>
				<p><label>*Category Group:</label>
   				<input type="checkbox" name="you_cat" id="you_cat" value="1" <?php if($_SESSION['biz_cat']['you_cat'] == '1') echo 'checked="checked"'; ?> />You Category <input type="checkbox" name="sjester" id="sjester" value="2" <?php if($_SESSION['biz_cat']['sjester'] == '2') echo 'checked="checked"'; ?>/>s'Jester </p>
				<p><label>*Sort Order:</label><input type="test" name="sortorder" id="sortorder" class="text-input small-input" /></p>
				<p><label>Category Status:</label>
				<select name="status" id="status">
				<option value="1" <?php if($_SESSION['biz_cat']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0" <?php if($_SESSION['biz_cat']['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>
				</p>
				  	
				<p style="width:100%">
				<input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;" name="Savecategory" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php
unset($_SESSION['biz_cat_err']);
unset($_SESSION['biz_cat']);
?>