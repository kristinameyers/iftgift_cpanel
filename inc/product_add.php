<h3><a href="<?php echo ruadmin; ?>home.php?p=product_manage">Products</a> &raquo; <a href="#" class="active">Add New Product</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Add New Product</h3>
		<div class="clear"></div>
	</div>
	
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['biz_pro_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_pro_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_pro_err']); ?>
	<div id="main">
		<form  method="post" action="<?php echo ruadmin; ?>process/process_product.php" enctype="multipart/form-data">
			<fieldset>
				<input name="userId" id="userId" type="hidden"  value="<?php echo $_SESSION['cp_cmd']['userId']; ?>"/>
				<p><label>*Product Name:</label><input name="pro_name" id="pro_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_pro']['pro_name']; ?>"/></p>
				
				<p><label>Product Short Detail:</label><textarea name="short_description" id="short_description" type="text" class="text-input small-input"><?php echo $_SESSION['biz_pro']['short_description']; ?></textarea></p>

				<p><label>Product Long Detail:</label><textarea name="long_description" id="long_description" type="text" class="text-input small-input"><?php echo $_SESSION['biz_pro']['long_description']; ?></textarea></p>

				
				<p><label>*Product Price:</label><input name="price" id="price" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_pro']['price']; ?>"/></p>
				
				<p>
				<label> Select Category:</label>
				<select name="category">
				<option value selected="selected">Select Category</option>
				<?php
				$pcatQry = mysql_query("SELECT catid, cat_name from ".tbl_category." where cat_type = 1 and status = 1");
				while($pshort = mysql_fetch_array($pcatQry)){
				?>
				<option style="font-weight:bold; color:#000000" disabled="disabled"><?php echo $pshort['cat_name']; ?></option>
				<?php 
				$catQry = mysql_query("SELECT catid, cat_name from ".tbl_category." where p_catid = ".$pshort['catid']." and status = 1");
                while($short = mysql_fetch_array($catQry)){?>
				<option value="<?php echo $short['catid']; ?>" <?php if($_SESSION['biz_pro']['category']==$short['catid']) { echo 'selected="selected"';}?> style="margin-left:20px;" ><?php echo $short['cat_name']; ?></option>
				<?php }	} ?>
				
				</select>
                </p>
				<p><label>Product Image:</label><input type="file" name="image" id="image" class="text-input small-input" /></p>
				
				
				<p><label>Status:</label>
				<select name="status" id="status">
				<option value="1"<?php if($_SESSION['biz_pro']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0"<?php if($_SESSION['biz_pro']['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>
				</p>
				
				</p>
				<p style="width:100%">
				<input type="submit" class="button" value="Save" name="SaveProduct" id="submit" />
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php
unset($_SESSION['biz_pro_err']);
unset($_SESSION['biz_pro']);
?>