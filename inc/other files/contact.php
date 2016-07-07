<?php

$qry="select * from cms  where page = 'contact'";
$rs=mysql_query($qry);
$row =mysql_fetch_array($rs);
$htmlData=$row['content'];
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Contact Us Content Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Contact Us Content Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
	<?php if ( isset ($_SESSION['msgText']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/<?php echo ru_img ?>icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php echo  $_SESSION['msgText']; unset($_SESSION['msgText']); ?>
			</div>
		</div>	
	<?php } ?>		
<form action="<?php echo ruadmin; ?>process/savetext.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $row['id'];?>"  />
<input type="hidden" name="page" id="page" value="contact" />
<table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
		<td width="123"  > Page Title:&nbsp;<br />
				<input type="text" id="title" name="title"  value="<?php echo $row['title'];?>" class="text-input" style="width:350px;"/>
	  </td>
	</tr>
	<tr>
		<td>Page Detail:&nbsp;<br />
		<textarea id="content" name="content"  class="text-input" rows="20"><?php echo stripslashes($row['content']);?></textarea>
		</td>
	</tr>
	<tr>
	  <td><input type="submit" class="button" name="Updateabout" value="Save"></td>
	</tr>
</table>
</form>
	</div>
</div>	        