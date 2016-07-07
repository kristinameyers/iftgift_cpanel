<?php
 $sql = "SELECT * from norio_images";
 $result =@mysql_query($sql) or die ( mysql_error());
 $total_pages = @mysql_num_rows($result);
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Image Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Image Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php echo $t;  ?>
		<?php if ( isset ($_SESSION['image_err']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['image_err']; unset($_SESSION['image_err']); ?>
				</div>
			</div>	
		<?php } ?>	
			
	<form  method="post" action="<?php echo ruadmin; ?>process/process_image.php"  enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD; ">
			  <tr><td colspan="3" align="left"><strong>Add New Image</strong></td></tr>
			  <tr>
				<td width="30%" align="right">Title: &nbsp;</td>
				<td width="20%"><input name="title" type="text" id="title" class="text-input" /></td>
				<td width="37%"><?php echo $_SESSION['titleerror'];unset($_SESSION['titleerror']);?></td>
			  </tr>
				<tr>
				<td width="30%" align="right"><strong>Photo:</strong></td>
				<td width="20%"><input name="photo" type="file" id="title" class="text-input" /></td>
				<td width="37%"><?php echo $_SESSION['titleerror'];unset($_SESSION['titleerror']);?></td>
			  </tr>
			  <tr>
				<td colspan="3">Note: Image should be Transparent, Size should be 220x100px and Type should be png, jpg or gif</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td align="left"><label>
				  <input type="submit" class="button" name="addimage" value="Add New Image" />
				</label></td>
				<td>&nbsp;</td>
			  </tr>
		</table>
	</form>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">

				  <tr>
					<td width="3%"><strong>Id</strong></td>
					<td width="15%"><strong>Title</strong></td>
					<td width="15%"><strong>Image</strong></td>																	
					<td width="15%"><strong>Action</strong></td>
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
							<td class="texttd"><?php echo $items['title'];?>  </td>
							<td class="texttd"><img src="<?php echo $ru;?>media/carimages/<?php echo $items['photo']; ?>" border="0" width="200" height="100" /> </td>
							<td valign="middle">
							<img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_image.php?action=del&imgid=<?php echo $items["image_id"];?>'}"  />&nbsp;&nbsp;							
							</td>
						  </tr>	
				  
						<?php
						}
					}
					?>	
				  <tr>
					<td  colspan="10"><?php include('common/paginglayout.php');?></td>
				  </tr>	     			
			</table>				
	</div>
</div>	