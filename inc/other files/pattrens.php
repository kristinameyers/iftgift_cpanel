<script type="text/javascript" src="jspattren.js"></script>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Pattern Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Pattern Management</h3>
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
<form action="<?php echo ruadmin; ?>process/process_pattrens.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD;">
 <tr>
    <td><strong>Add New Pattern</strong>
	   <?php if ( isset ($_SESSION['biz_pattren_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_pattren_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_pattren_err']); ?> </td>										
  </tr>
  <tr>
    <td>Pattern Name:&nbsp;&nbsp;&nbsp;&nbsp;<input name="name" type="text" id="name" style="width:250px;" class="text-input" /></td>
  </tr>
   <tr>
    <td>Pattern Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="pcode_name" type="text" id="pcode_name" style="width:250px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Reference Code:&nbsp;<input name="pref_code" type="text" id="pref_code" style="width:250px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Pattern Image:&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" id="logo" name="logo" size="27"></td>
  </tr>
   <tr>
    <td>Pattern Price: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="price" type="text" id="price" class="text-input " value="0" style=" width:250px;"></td>
  </tr>

  <tr>
    <td style="padding-left:105px"><input type="submit" class="button" name="Savepattren" value="Add new pattren" /></td>
  </tr>

</table>
</form>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td colspan="7">
	<?php 
		  $sql = "SELECT * from pattren "; 
		 if(isset($_GET['key']) && $_GET['key']!=''){
			 		 
		 	$sql .= " where pref_code = '".$_GET['key']."' ";
		 
		 }
		 
		 $result =@mysql_query($sql) or die ( mysql_error());
		 $total_pages = @mysql_num_rows($result);
		 echo "Total pattrens: ".$total_pages;
	?>  </tr>
  <tr>
  	<td colspan="7"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
    <tr>
    <td colspan="7" style="font-weight:bold;" height="40">
	Sort By Reference Code	</td>
</tr>
   <tr>
    <td colspan="7" style="font-weight:bold; height:45px; padding:0px;">
	<?php 
		 $sql_ref = mysql_query("SELECT distinct pref_code from pattren order by pref_code");
		 while($rowRef = mysql_fetch_array($sql_ref)){
		 ?>
		<a href="home.php?p=pattrens&key=<?php echo $rowRef['pref_code']; ?>" style="padding:7px 10px; background-color:#f1f1f1;"> <?php echo $rowRef['pref_code']; ?></a>
		 <?php
		 }
	?>	</td>
  <tr>
  <tr>
    <td width="7%"><strong>Sr. Id</strong></td>
    <td width="18%"><strong>Pattern Name</strong></td>
	<td width="19%"><div align="center"><strong>Pattern Code</strong></div></td>
	<td width="10%"><div align="center"><strong>Reference Code</strong></div></td>
	<td width="20%"><div align="center"><strong>Image</strong></div></td>
    <td width="10%"><div align="center"><strong>Price</strong></div></td>
    <td width="17%"><div align="center"><strong>Action</strong></div></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " ORDER BY pref_code ,pcode_name  LIMIT ".$start.",".$limit;
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
				<td><div align="center"><?php echo $row['pcode_name'];?> </div></td>
				<td><div align="center"><?php echo $row['pref_code'];?> </div></td>
				<td><div align="center"><img src="media/pattrens/logo/<?php echo $row['logo'];?>" width="120"/></div></td>
                <td><div align="center"><?php echo $row['price'];?> </div></td>
                
				<td width="17%" align="center">
					<div align="center"><img src="images/edit.gif" style="cursor:pointer;" title="Edit Pattern" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='block'"  /> &nbsp;&nbsp;
		        <img src="images/dlt.gif" style="cursor:pointer;" title="Delete Pattern" alt="Delete Pattern" onclick="if(confirm('Are sure you want to delete')){window.location='process/process_pattrens.php?action=d&Id=<?php echo $row["Id"]; ?>' }"  />				</div></td>
		      </tr>	
			  <tr>
			   <td colspan="7">
			   	<div id="<?php echo $row['Id'];?>" style="display:none; float:left; width:100%">
				<form action="<?php echo ruadmin; ?>process/process_pattrens.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="Id" value="<?php echo $row['Id'];?>"  />
				<input type="hidden" name="oldlogo" value="<?php echo $row['logo'];?>"  />
				<strong>Pattern Name:</strong>
				<input type="text" id="title" name="name"  value="<?php echo $row['name'];?>" class="text-input" style="width:120px;"/>
				&nbsp;
				<strong>Pattern Code:</strong>
				<input type="text" id="title" name="pcode_name"  value="<?php echo $row['pcode_name'];?>" class="text-input"  style="width:60px;"/>
				&nbsp;
				<strong>Ref Code:</strong>
				<input type="text" id="title" name="pref_code"  value="<?php echo $row['pref_code'];?>" class="text-input"  style="width:60px;"/>
				&nbsp;
				<strong>Image:</strong>&nbsp;<input type="file" id="logo" name="logo"  style="width:230px;">
                 &nbsp;
				<strong>Price:</strong>&nbsp;
                	<input name="price" type="text" id="price" class="text-input " value="<?php echo $row['price'];?>" style=" width:40px;">    
				
				        
				<input type="submit" name="Updatepattren" class="button" value="Update Pattern" onclick="if(document.getElementById('title').value==''){alert('Enter Pattern Name'); return false;}" />&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='none'" class="button"  />
				</form>
				</div>			  </td> 
			  </tr>
	        <?php
		}
	?>	
  <tr>
    <td colspan="7"><?php include('common/paginglayout.php');?></td>
  </tr>	  		 
</table>
	</div>
</div>	