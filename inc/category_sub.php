<?php
mysql_query("SET NAMES 'utf8'");
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Sub-Category Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Sub-Category Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
	<?php if ( isset ($_SESSION['statuss']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php echo  $_SESSION['statuss']; unset($_SESSION['statuss']); ?>
			</div>
		</div>	
	<?php } ?>
<form action="<?php echo ruadmin; ?>process/process_category.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD; ">
  <tr>
    <td colspan="3" align="left"><strong>Add New Sub-Category </strong></td>										
  </tr>
  <tr>
    <td  align="right">Select Category: &nbsp;</td>
    <td><select name="cat" id="cat" >
				<?php 
		
		 $sql = "SELECT catid, cat_name from ".tbl_category." where p_catid = 0 and cat_type=1";
		 $result =@mysql_query($sql);
		 while ($row = mysql_fetch_array( $result ) ){ 
		 	$catval = $row['catid'];
			echo '	<option  value="'.$catval.'"  >'.$row['cat_name'].' </option>';

		 }
		  ?></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20%"  align="right">*Sub-Category: &nbsp;</td>
    <td width="26%"><input name="cat_name" type="text" id="cat_name"  class="text-input" /></td>
    <td width="37%" style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $_SESSION['biz_subcat_err']['cat_name'];unset($_SESSION['biz_subcat_err']['cat_name']);?></td>
  </tr>
  <tr>
  <td width="20%"  align="right">*Sort Order: &nbsp;</td>
   <td width="26%"><input name="sortorder" type="text" id="sortorder"  class="text-input" /></td>
   <td width="37%" style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $_SESSION['biz_subcat_err']['ordererror'];unset($_SESSION['biz_subcat_err']['ordererror']);?></td>
  </tr>
   <tr>
  <td width="20%"  align="right">Status: &nbsp;</td>
   <td width="26%" colspan="4"><select name="status" id="status" style="float:left; margin-left:78px">
   <option value="1"<?php if($_SESSION['biz_subcat_err']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
   <option value="0"<?php if($_SESSION['biz_subcat_err']['status'] == '1') echo 'selected="selected"'; ?>>Inactive</option>
   </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><label>
      <input type="submit" class="button" name="subcategory" value="Add new sub category" />
    </label></td>
    <td>&nbsp;</td>
  </tr>


</table>
</form>
<br/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td colspan="8" align="center"  style="text-align:left">
    <form method="post">
    	Sub-Category: <input type="text" size="39" class="text-input"  name="searchkw" value="<?php echo trim( $_POST['searchkw'] )?>" />&nbsp;&nbsp;<input type="submit" class="button" value="Search" name="Search"  /></form>
    </form>

    	</td>
   </tr>
   <tr>
    <td  colspan="8">
	<div style="float:left">
	<?php 
		$filterby 	= 'Where  p_catid <> 0';
		
		if( isset ($_GET['cid'] ) and  trim( $_GET['cid']) != '') {
			$cid = $_GET['cid'];
			if($cid==0){ $cid = ""; }
			$filterby .= " and  p_catid = ".$cid ;
		}
		if ( isset ($_POST['searchkw'] ) and trim ($_POST['searchkw']!='')){
			$filterby .= " and cat_name like '".$_POST['searchkw']."%' or cat_name like '%".$_POST['searchkw']."%' ";
		}

		$sql = "SELECT * from ".tbl_category."  $filterby order by cat_name";

		$result =@mysql_query($sql);
		$total_pages = @mysql_num_rows($result);
		echo "Total Sub-Category : ".$total_pages;
	?>
    </div>
	 <div style="float:right; margin-right:5px;">
          
     
     &nbsp;&nbsp;
     Filter By Category: <select name="cid" id="cid"  onChange="{window.location='home.php?p=category_sub&cid=' + this.value}" >
				<option  value="" >---------List by Category-------------</option>
				<?php 
		
		 $sqlInds = "SELECT  catid, cat_name  from ".tbl_category." where p_catid = 0 and cat_type=1";
		 $resultInds =@mysql_query($sqlInds);
		 while ($rowInds = mysql_fetch_array( $resultInds ) ){ 
		 	$sel = '  ';

		 	if ( $cid == $rowInds	['catid'] ) $sel = ' Selected = "Selected" ';
			echo '	<option  value="'.$rowInds['catid'].'" '.$sel.' >'.$rowInds['cat_name'].' </option>';

		 }
		  ?>
		 
		  </select>
          </div>
          </td>
  <tr>
  <tr>
  	<td colspan="4"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
  <tr>
    <td width="5%"><strong>Id</strong></td>
    <td width="30%"><strong>Sub-Category</strong></td>
    <td width="15%"><strong>You Category</strong></td>
	 <td width="15%"><strong>s'Jester</strong></td>
	<td width="10%"><strong>Sortorder</strong></td>
	<td width="10%"><strong>Status</strong></td>
    <td width="9%"><strong>Action</strong></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " LIMIT ".$start.",".$limit;
		 $i=$i+$start;
		 $result = @mysql_query($sql);
		 $rec = array();
		 while( $row = @mysql_fetch_array($result) )
		 {
			$rec[] = $row;
		 }
		if(count($rec)>0)
		{
			foreach($rec as $items)
			{
			

			?>
			
			  <tr>
				<td><?php echo ++$i;?> </td>
				<td><?php echo $items['cat_name'];?> </td>
				<?php
					$pcat = mysql_query("select * from ".tbl_category." where catid = ".$items['p_catid']." and p_catid = 0"); 
					while($parent = mysql_fetch_array($pcat))
					{
				?>
				<td><?php if($parent['you_cat'] == '1') { echo $parent['cat_name']; } else { echo '---';}?> </td>
				<td><?php if($parent['sjester'] == '2') { echo $parent['cat_name']; } else { echo '---';}?> </td>
				<?php } ?>
				<td><?php echo $items['sortorder'];?> </td>
				<td><?php if($items['status'] == '1')
							{
								echo "Active";
							} else 
							{
								echo "Inactive";
							}
							?> </td>
				<td valign="middle">
					<img src="images/edit.gif"  style="cursor:pointer;" title="Edit Sub-Category" onclick="document.getElementById('<?php echo $items['catid'];?>').style.display='block'"  />	&nbsp;&nbsp;
				    <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete Sub-Category" alt="Delete Sub-Category" onclick="if(confirm('Are sure you want to delete')){window.location='<?php echo ruadmin; ?>process/process_category.php?action=delsubcat&page=<?php echo $_GET['page'];?>&cid=<?php echo $items["catid"]; ?>' }"  />
				</td>
		      </tr>	
			  <tr>
			   <td colspan="8"><div id="<?php echo $items['catid'];?>" style="display:none;">
			   <form action="<?php echo ruadmin; ?>process/process_category.php" method="post">
			   Sub-Category:<input  type="text" id="title" name="title"  value="<?php echo $items['cat_name'];?>" size="39"  class="text-input"/>&nbsp;
               <select name="cat" id="cat" > 
				<?php 
					
					 $sqlInds = "SELECT  catid, cat_name  from ".tbl_category." where p_catid = 0  and cat_type=1";
					 $resultInds =@mysql_query($sqlInds);
					 while ($rowInds = mysql_fetch_array( $resultInds ) ){ 
					 
						echo '	<option  value="'.$rowInds['catid'].'" ';
						if ($items['p_catid'] == $rowInds['catid'] ) echo '  selected="selected" ';
						echo ' >'.$rowInds['cat_name'].' </option>';
					 }
		 	 ?>
		    </select>&nbsp;
			<input  type="text" id="sortorder" name="sortorder"  value="<?php echo $items['sortorder'];?>" size="35"  class="text-input"/>&nbsp;
			<select name="status" id="status">
				<option value="1" <?php if($items['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0" <?php if($items['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>&nbsp;
				<input type="hidden" id="catid" name="catid"  value="<?php echo $items['catid'];?>"/>
				<input type="submit" class="button" name="editsubcategory" value="Update"  />
				&nbsp;<input type="button"  class="button" value="Cancel" onclick="document.getElementById('<?php echo $items['catid'];?>').style.display='none'"  />
				</form>
				</div>
			  </td> 
			  </tr>
			  
	        <?php
			}
		}
	?>	
  <tr>
    <td  colspan="4"><?php include('common/paginglayout.php');?></td>
  </tr>	     
</table>
	</div>
</div>	