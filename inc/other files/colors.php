<script type="text/javascript" src="jscolor.js"></script>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Color Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Color Management</h3>
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
<form action="<?php echo ruadmin; ?>process/process_colors.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD;">
 <tr>
    <td><strong>Add New Color</strong>
	   <?php if ( isset ($_SESSION['biz_color_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_color_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } unset ($_SESSION['biz_color_err']); ?> </td>										
  </tr>
  <tr>
    <td>Color Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="name" type="text" id="name" style="width:250px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Color Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="code_name" type="text" id="code_name" style="width:250px;" class="text-input" /></td>
  </tr>
   <tr>
    <td>Reference Code:&nbsp;<input name="ref_code" type="text" id="ref_code" style="width:250px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Pick Color: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="code" type="text" id="code" class="text-input color" value="66ff00" style="background-image:none; width:250px;"></td>
  </tr>
  <tr>
    <td>Color Price: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="price" type="text" id="price" class="text-input " value="0" style=" width:250px;"></td>
  </tr>
  <tr>
    <td style="padding-left:105px"><input type="submit" class="button" name="Savecolor" value="Add new color" /></td>
  </tr>

</table>
</form>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td colspan="7">
	<?php 
		
		 $sql = "SELECT * from color "; 
		 if(isset($_GET['key']) && $_GET['key']!=''){
			 		 
		 	$sql .= " where ref_code = '".$_GET['key']."' ";
		 
		 }
		 
		 $result =@mysql_query($sql) or die ( mysql_error());
		 $total_pages = @mysql_num_rows($result);
		 echo "Total colors: ".$total_pages;
	?>  </tr>
  <tr>
  	<td colspan="7"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
  <tr>
    <td colspan="7" style="font-weight:bold;" height="40">
	Sort By Reference Code
	</td>
</tr>
   <tr>
    <td colspan="7" style="font-weight:bold; height:45px; padding:0px;">
	<?php 
		 $sql_ref = mysql_query("SELECT distinct ref_code from color order by ref_code");
		 while($rowRef = mysql_fetch_array($sql_ref)){
		 ?>
		<a href="home.php?p=colors&key=<?php echo $rowRef['ref_code']; ?>" style="padding:7px 10px; background-color:#f1f1f1;"> <?php echo $rowRef['ref_code']; ?></a>
		 <?php
		 }
	?> 
	</td>
  <tr>
    <td width="7%"><strong>Sr. Id</strong></td>
    <td width="18%"><strong>Color Name</strong></td>
	<td width="19%"><div align="center"><strong>Color Code</strong></div></td>
	<td width="10%"><div align="center"><strong>Reference Code</strong></div></td>
    <td width="20%"><div align="center"><strong>Color</strong></div></td>	
    <td width="10%"><div align="center"><strong>Price</strong></div></td>	
    <td width="20%"><div align="right"><strong>Action</strong></div></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " ORDER BY ref_code ,code_name  LIMIT ".$start.",".$limit;
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
				<td><div align="center"><?php echo $row['code_name'];?> </div></td>
				<td><div align="center"><?php echo $row['ref_code'];?> </div></td>
				<td align="center"><div style="width:85px; margin-left:63px; text-align:center; height:30px; background-color:#<?php echo $row['code'];?>;"></div></td>
                <td><div align="center"><?php echo $row['price'];?> </div></td>
				<td align="right">
                   <img src="images/edit.gif" align="right" style="cursor:pointer;" title="Edit color" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='block'"  /> &nbsp;&nbsp;
                   &nbsp;   
                   <img src="images/dlt.gif" align="right" style="cursor:pointer;" title="Delete color" alt="Delete color" onclick="if(confirm('Are sure you want to delete')){window.location='process/process_colors.php?action=d&Id=<?php echo $row["Id"]; ?>' }"  />				
                      </td>
		      </tr>	
			  <tr>
			   <td colspan="7">
			   	<div id="<?php echo $row['Id'];?>" style="display:none; float:left; width:100%">
				<form action="<?php echo ruadmin; ?>process/process_colors.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="Id" value="<?php echo $row['Id'];?>"  />
				<strong>Color Name:</strong>&nbsp;<input type="text" id="title" name="name"  value="<?php echo $row['name'];?>" class="text-input" style="width:120px;"/>
				&nbsp;
				
				<strong>Color Code:</strong>&nbsp;<input name="code_name" type="text" id="code_name" value="<?php echo $row['code_name'];?>" class="text-input" style="width:70px;"/> 
				&nbsp;
                    <strong>Reference Code:</strong>&nbsp;<input type="text" id="ref_code" name="ref_code" value="<?php echo $row['ref_code'];?>" class="text-input" style="width:70px;"/>
				&nbsp;
				<strong>Pick Color:</strong>&nbsp;<input type="text" id="code" name="code" value="<?php echo $row['code'];?>" class="color" style="width:50px;">
                &nbsp;
				<strong>Price:</strong>&nbsp;
                	<input name="price" type="text" id="price" class="text-input " value="<?php echo $row['price'];?>" style=" width:40px;">    
				<input type="submit" name="Updatecolor" class="button" value="Update color" onclick="if(document.getElementById('title').value==''){alert('Enter color Name'); return false;}" />&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='none'" class="button"  />
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