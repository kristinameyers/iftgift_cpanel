<h3><a href="#">Home</a> &raquo; <a href="#" class="active">About Us Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>About Us Management</h3>
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
<form action="<?php echo ruadmin; ?>process/savetext.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="page" id="page" value="aboutus" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD;">
 <tr>
    <td><strong>Add New Text</strong>
	   <?php if ( isset ($_SESSION['biz_cat_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_cat_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_cat_err']); ?> </td>										
  </tr>
  <tr>
    <td>Page Title:&nbsp;<br />
	<input name="title" type="text" id="title" style="width:350px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Page Detail:&nbsp;<textarea id="content" name="content"  class="text-input"></textarea></td>
  </tr>
  <tr>
    <td style="padding-left:10px"><input type="submit" class="button" name="Saveabout" value="Add new text" /></td>
  </tr>

</table>
</form>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td colspan="5">
	<?php 
		 $sql = "SELECT * from cms where page = 'aboutus'";
		 //echo $sql;exit;
		 $result =@mysql_query($sql) or die ( mysql_error());
		 $total_pages = @mysql_num_rows($result);
		 echo "Total Categories: ".$total_pages;
	?>  </tr>
  <tr>
  	<td colspan="5"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
  <tr>
    <td width="9%"><strong>Id</strong></td>
    <td width="25%"><strong>Title</strong></td>
    <td width="50%"><div align="left"><strong>Detail</strong></div></td>	
    <td width="16%"><div align="center"><strong>Action</strong></div></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " ORDER BY id DESC LIMIT ".$start.",".$limit;
		 $i=$i+$start;
		 //echo $sql;exit;
		 $result = @mysql_query($sql);
		 $rec = array();
		 while( $row = @mysql_fetch_array($result) )
		 {
	
			?>
			  <tr>
				<td><?php echo ++$i;?> </td>
				<td><?php echo $row['title'];?> </td>
				<td><div align="left"><?php echo stripslashes($row['content']);?> </div></td>
				<td align="center">
					<div align="center"><img src="images/edit.gif" style="cursor:pointer;" title="Edit about" onclick="document.getElementById('<?php echo $row['id'];?>').style.display='block'"  /> &nbsp;&nbsp;
				      <img src="images/dlt.gif" style="cursor:pointer;" title="Delete about" alt="Delete about" onclick="if(confirm('Are sure you want to delete')){window.location='process/savetext.php?action=d&page=aboutus&Id=<?php echo $row["id"]; ?>' }"  /></div></td>
		      </tr>	
			  <tr>
			   <td colspan="5">
			   	<div id="<?php echo $row['id'];?>" style="display:none; float:left; width:100%">
				<form action="<?php echo ruadmin; ?>process/savetext.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $row['id'];?>"  />
				<input type="hidden" name="page" id="page" value="aboutus" />
				<strong>Title:</strong>&nbsp;&nbsp;
				<input type="text" id="title" name="title"  value="<?php echo $row['title'];?>" class="text-input" style="width:350px;"/>
				&nbsp;<br />
				<strong>Detail:</strong>&nbsp;<textarea id="content" name="content"  class="text-input"><?php echo stripslashes($row['content']);?></textarea>
				        
				<input type="submit" name="Updateabout" class="button" value="Update text" />&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $row['id'];?>').style.display='none'" class="button"  />
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