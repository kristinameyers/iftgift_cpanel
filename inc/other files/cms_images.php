<script type="text/javascript" src="jsimage.js"></script>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">CMS Images Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>CMS Images Management</h3>
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
<!--<form action="<?php echo ruadmin; ?>process/cms_images.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD;">
 <tr>
    <td><strong>Add New image</strong>
	   <?php if ( isset ($_SESSION['biz_image_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_image_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_image_err']); ?> </td>										
  </tr>
   <tr>
    <td>Select Page:&nbsp;
	<select name="page" class="text-input" >
	<option value="aboutus">About Us</option>
	<option value="creator">The Creator</option>
	</select>
	</td>
  </tr>
  <tr>
  <tr>
    <td>Image Name:&nbsp;<input name="name" type="text" id="name" style="width:250px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Upload Image:&nbsp;<input type="file" id="logo" name="logo" size="27"></td>
  </tr>
  <tr>
    <td style="padding-left:90px"><input type="submit" class="button" name="Saveimage" value="Add New Image" /></td>
  </tr>

</table>
</form>-->
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td colspan="5">
	<?php 
		 $sql = "SELECT * from cms_images";
		 //echo $sql;exit;
		 $result =@mysql_query($sql) or die ( mysql_error());
		 $total_pages = @mysql_num_rows($result);
		 echo "Total images: ".$total_pages;
	?>  </tr>
  <tr>
  	<td colspan="5"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
  <tr>
    <td width="13%"><strong>Id</strong></td>
    <td width="44%"><strong>Image Name</strong></td>
    <td width="23%"><div align="left"><strong>Image</strong></div></td>	
    <td width="20%"><div align="center"><strong>Action</strong></div></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " ORDER BY Id ASC LIMIT ".$start.",".$limit;
		 $i=$i+$start;
		 //echo $sql;exit;
		 $result = @mysql_query($sql);
		 $rec = array();
		 while( $row = @mysql_fetch_array($result) )
		 {
	
			?>
			  <tr>
				<td><?php echo ++$i;?> </td>
				<td><?php echo $row['name'];?> </td>
				<td>
				<img src="<?php echo 'media/cms/'.$row['logo'];?>" height="70"/>
				</td>
				<td align="center">
					<div align="center"><img src="images/edit.gif" style="cursor:pointer;" title="Edit imagee" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='block'"  /> &nbsp;&nbsp;
				     <!-- <img src="images/dlt.gif" style="cursor:pointer;" title="Delete imagee" alt="Delete imagee" onclick="if(confirm('Are sure you want to delete')){window.location='process/cms_images.php?action=d&Id=<?php echo $row["Id"]; ?>' }"  />				</div>--></td>
		      </tr>	
			  <tr>
			   <td colspan="5">
			   	<div id="<?php echo $row['Id'];?>" style="display:none; float:left; width:100%">
				<form action="<?php echo ruadmin; ?>process/cms_images.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="Id" value="<?php echo $row['Id'];?>"  />
				<input type="hidden" name="oldlogo" value="<?php echo $row['logo'];?>"  />
				<strong>Image Name:</strong>
				<input type="text" id="title" name="name"  value="<?php echo $row['name'];?>" class="text-input"/>
				&nbsp;
				<strong>Upload Image:</strong>&nbsp;<input type="file" id="logo" name="logo">
				        
				<input type="submit" name="Updateimage" class="button" value="Update Image" onclick="if(document.getElementById('title').value==''){alert('Enter image Name'); return false;}" />&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='none'" class="button"  />
				</form>
				</div>			  </td> 
			  </tr>
	        <?php
		}
	?>	
  <tr>
    <td colspan="5"><?php include('common/paginglayout.php');?></td>
  </tr>	  		 
</table>
	</div>
</div>	