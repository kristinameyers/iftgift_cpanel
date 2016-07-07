<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Ocassion Group Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Ocassion Group Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
	<?php if ( isset ($_SESSION['statusss']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php echo  $_SESSION['statusss']; unset($_SESSION['statusss']); ?>
			</div>
		</div>	
	<?php } ?>
<form action="<?php echo ruadmin; ?>process/process_ocassion.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD; ">
  <tr>
    <td colspan="3" align="left"><strong>Add New Ocassion Group </strong></td>										
  </tr>
  <tr>
    <td width="20%"  align="right">*Group Name: &nbsp;</td>
    <td width="26%"><input name="group_name" type="text" id="group_name"  class="text-input" /></td>
    <td width="37%" style="color:#FF0000; font-family:Arial, Helvetica, sans-serif; font-size:12px;"><?php echo $_SESSION['biz_group_err']['group_name'];unset($_SESSION['biz_group_err']['group_name']);?></td>
  </tr>
   <tr>
  <td width="20%"  align="right">Status: &nbsp;</td>
   <td width="26%" colspan="4"><select name="status" id="status" style="float:left; margin-left:78px">
   <option value="1"<?php if($_SESSION['biz_group_err']['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
   <option value="0"<?php if($_SESSION['biz_group_err']['status'] == '1') echo 'selected="selected"'; ?>>Inactive</option>
   </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><label>
      <input type="submit" class="button" name="ocassiongroup" value="Add new Ocassion Group" />
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
		$filterby 	= 'Where  p_occasionid = 0';
		
		if( isset ($_GET['cid'] ) and  trim( $_GET['cid']) != '') {
			$cid = $_GET['cid'];
			if($cid==0){ $cid = ""; }
			$filterby .= " and  p_occasionid = ".$cid ;
		}
		if ( isset ($_POST['searchkw'] ) and trim ($_POST['searchkw']!='')){
			$filterby .= " and occasion_name like '".$_POST['searchkw']."%' or occasion_name like '%".$_POST['searchkw']."%' ";
		}

		$sql = "SELECT * from ".tbl_occasion."  $filterby order by occasion_name";

		$result =@mysql_query($sql);
		$total_pages = @mysql_num_rows($result);
		echo "Total Groups : ".$total_pages;
	?>
    </div>
	 
          </td>
  <tr>
  <tr>
  	<td colspan="4"><?php echo $_SESSION['statusss']; unset($_SESSION['statusss']);?></td>
  </tr>
  <tr>
    <td width="5%"><strong>Id</strong></td>
    <td width="30%"><strong>Ocassion Group</strong></td>
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
				<td><?php echo $items['occasion_name'];?> </td>
				<td><?php if($items['status'] == '1')
							{
								echo "Active";
							} else 
							{
								echo "Inactive";
							}
							?> </td>
				<td valign="middle">
					<img src="images/edit.gif"  style="cursor:pointer;" title="Edit Sub-Category" onclick="document.getElementById('<?php echo $items['occasionid'];?>').style.display='block'"  />	&nbsp;&nbsp;
				    <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete Sub-Category" alt="Delete Sub-Category" onclick="if(confirm('Are sure you want to delete')){window.location='<?php echo ruadmin; ?>process/process_ocassion.php?action=delgroup&page=<?php echo $_GET['page'];?>&cid=<?php echo $items["occasionid"]; ?>' }"  />
				</td>
		      </tr>	
			  <tr>
			   <td colspan="8"><div id="<?php echo $items['occasionid'];?>" style="display:none;">
			   <form action="<?php echo ruadmin; ?>process/process_ocassion.php" method="post">
			   Group Name:<input  type="text" id="title" name="title"  value="<?php echo $items['occasion_name'];?>" size="39"  class="text-input"/>&nbsp;
			<select name="status" id="status">
				<option value="1" <?php if($items['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
				<option value="0" <?php if($items['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
				</select>&nbsp;
				<input type="hidden" id="catid" name="catid"  value="<?php echo $items['occasionid'];?>"/>
				<input type="submit" class="button" name="editgroup" value="Update"  />
				&nbsp;<input type="button"  class="button" value="Cancel" onclick="document.getElementById('<?php echo $items['occasionid'];?>').style.display='none'"  />
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