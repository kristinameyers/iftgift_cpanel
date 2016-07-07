<?php 
	if( isset ( $_POST['Submit'] ))
	{
		$gcode = stripslashes(trim($_POST['gcode']));
		
		file_put_contents('../inc/analytics.php',$gcode);
		$_SESSION['statuss'] = "Google Analytics Code  - Updated Successfuly "; 
		header('location:'.ruadmin.'home.php?p=analytics');
		exit;
	}
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Google Analytics Setting</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Google Analytics Setting</h3>
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
	<form action="<?php echo ruadmin; ?>home.php?p=analytics" method="post">
	<table width="100%" cellpadding="0" cellspacing="0" style="padding-left:20px;">
	  <tr>
	
		<td width="23%"><strong>Google Analytics Code: </strong></td>
	
	  <tr>
	
		<td width="77%">
		  <textarea rows="12" cols="91" name="gcode"><?php echo file_get_contents('../inc/analytics.php'); ?></textarea>
	  </td>
	  </tr>
	
	  
	  <tr>
		<td align="right"  style="padding-right:20px;">      <input type="submit" class="button" name="Submit" value="Update" /></td>
	  </tr>
	</table>
	</form>
	</div>
</div>	
