<?php 
if ( isset ($_POST['doSearch'] ) ) { 
	$_SESSION['c_status']=$_POST['status'];
	$_SESSION['searchkw']=trim($_POST['searchkw']);
	$_SESSION['c_sortby']=$_POST['sortby'];
	header("location:".$ruadmin."home.php?p=manage_header_image");exit;
}
$qry_banner = "SELECT * FROM banner ";
$rs_banner = $db->get_results($qry_banner,ARRAY_A);
?>
<style>
.add_new_cat {
  float:right;
  width:150px;
}

.add_new_cat img {
  float:left;
  margin-top:12px;
}
.add_new_cat h4 {
  font-size:14px;
  margin-left:20px;
  margin-top:14px;
  
}
.add_new_cat h4:hover{
 color: #000 ;
 text-decoration:underline;
  
}
</style>
<h3><a href="#">Banner Images</a> &raquo; <a href="#" class="active">Manage Banner images </a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Manage Banner Images</h3>
			<div style="float:right;width:47%;">
			<span class="add_new_cat" style="width:44%;"><a href="<?php echo $ruadmin ?>home.php?p=banner_add"><img src="<?php echo $ruadmin ;?>images/icons/new_faq_class.png" alt="Add New Header Image" /><h4>Add New banner image</h4></a></span>
			</div>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
	 <?php if ( isset ($_SESSION['success']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['success'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['success']); ?>				
	
		<!--Search Filter Start from there-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
         
        
           
         	<tr>
				<td width="12%">S No:</td>
				<td width="20%">Image</td>
				<td width="20%">Url</td>
				<td width="20%">Status</td>	
				<td width="16%">Edit/Delete</td>
			</tr>
      
			<?php 
				if($rs_banner){
					$count = 0;
					foreach($rs_banner as $rs_ban){
						$count++;
			?>
			<tr>
				<td><?php echo $count; ?></td>
		
				<td><img src="<?php echo $ru.'media/banner/'.$rs_ban['image']?>" height="70px" width="120px"/></td>
				<td><?php echo $rs_ban['url']?></td>		
				<td><?php if($rs_ban['status']==1){ echo "Active";}else{echo "Inactive";} ?></td>
						
				<td valign="middle">
				
				<img src="images/edit.gif"  style="cursor:pointer;" title="Edit Service Image" alt="Edit Banner Image" onClick="window.location='<?php echo $ruadmin?>home.php?p=banner_edit&banner_id=<?php echo $rs_ban["id"];?>'"  />
						<img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo $ruadmin; ?>process/process_banner.php?action=d&banner_id=<?php echo $rs_ban["id"];?>'}"  />&nbsp;&nbsp;							</td>
						  </tr>	
			<?php 
					}
				}
			?>		
		
		</table>		
	</div>
</div>	
<?php unset($_SESSION['success']);?>