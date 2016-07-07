<h3><a href="<?php echo ruadmin; ?>home.php?p=product_manage">Ocassion</a> &raquo; <a href="#" class="active">Add New Ocassion</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Add New Ocassion</h3>
		<div class="clear"></div>
	</div>
	
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['biz_ocs_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_ocs_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_ocs_err']); ?>
	<div id="main">
		<form  method="post" action="<?php echo ruadmin; ?>process/process_ocassion.php">
			<fieldset>
				
				<p><label>*Ocassion Name:</label><input name="occasion_name" id="occasion_name" type="text" class="text-input small-input"  value="<?php echo $_SESSION['biz_ocs']['occasion_name']; ?>"/></p>
				<p><label>*Ocassion Group:</label>
   				<select name="group" id="group" >
				<?php 
		
		 $sql = "SELECT occasionid, occasion_name from ".tbl_occasion." where p_occasionid = 0 and occasion_type=1";
		 $result =@mysql_query($sql);
		 while ($row = mysql_fetch_array( $result ) ){ 
		 	$catval = $row['occasionid'];
		?>	
			<option  value="<?php echo $catval;?>" <?php if($_SESSION['biz_ocs']['group'] == $catval) echo 'selected="selected"'; ?>><?php echo $row['occasion_name'];?></option>
		<?php
		 }
		  ?></select></p>
			<script type="text/javascript">
			$.noConflict();
			jQuery(function(){
				jQuery("#categories").multiselect();
			});
			</script>
		  <p><label>Method:</label>
				<select name="method" id="method">
				<option value="0" <?php if($_SESSION['biz_ocs']['method'] == '0') echo 'selected="selected"'; ?>>With All</option>
				<option value="1" <?php if($_SESSION['biz_ocs']['method'] == '1') echo 'selected="selected"'; ?>>Other Then These Categories</option>
				<option value="2" <?php if($_SESSION['biz_ocs']['method'] == '2') echo 'selected="selected"'; ?>>Within These Categories</option>
				</select>
				</p>
				<p id="selected_cat" style="display:none"><label>*Categories:</label>
				<?php
				$category = $_SESSION['biz_ocs']['categories'];
				?>
					<select title="Basic example" id="categories" multiple="multiple" name="categories[]" size="5">
					<?php 
						$sql = "SELECT catid, cat_name from ".tbl_category." where p_catid = 0 and cat_type=1";
						$result =@mysql_query($sql);
						while ($row = mysql_fetch_array( $result ) ){ 
						$catval = $row['cat_name'];
						$select = in_array( $catval, $category );
						?>
						<option  value="<?php echo $catval;?>" <?php if($select == $catval) echo 'selected="selected"'; ?>><?php echo $row['cat_name'];?></option>
						<?php 
						}
				 	 ?>
					</select></p>
				<script type="text/javascript">
				$(function () {
					$('#method').change(function () {
						var id = $('#method').val();
						if(id == 1) {
						$('#selected_cat').show();
						} else if(id == 2) {
						$('#selected_cat').show();
						} else if(id == 0) {
						$('#selected_cat').hide();
						}
					});
				});
				</script>	
				<p><label>Ocassion Status:</label>
				<select name="status" id="status">
				<option value="1" <?php if($_SESSION['biz_ocs']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0" <?php if($_SESSION['biz_ocs']['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>
				</p>
				  	
				<p style="width:100%">
				<input type="submit" class="button" value="&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;" name="Saveocassion" id="submit" />
				</p>
				<p style="width:100%">
				
				</p>
				<p style="width:100%">
				
				</p>
				<p style="width:100%">
				
				</p>
			</fieldset>
		</form>
		</div>
	</div>
</div>
<?php
unset($_SESSION['biz_ocs_err']);
unset($_SESSION['biz_ocs']);
?>