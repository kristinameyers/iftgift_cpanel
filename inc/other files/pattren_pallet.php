<script type="text/javascript" src="jsPattren Pallet.js"></script>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Pattern Pallet Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Pattern Pallet Management</h3>
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
<form action="<?php echo ruadmin; ?>process/process_pattren_pallets.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD;">
 <tr>
    <td><strong>Add New Pattern Pallet</strong>
	   <?php if ( isset ($_SESSION['biz_pattren_pallet_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_pattren_pallet_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } ?> </td>										
  </tr>
  
   <?php 
  $pattrenData = array();
  $sqlpattren = mysql_query(" SELECT * from pattren ORDER BY pref_code ,pcode_name ");
	while($resultpattren   = mysql_fetch_array($sqlpattren))
	{
		$pattrenData[$resultpattren['Id']] = $resultpattren;
	}
	
?>
  
  <tr>
    <td>Pattern Pallet Name:&nbsp;&nbsp;&nbsp;
	
      <input name="name" type="text" id="name" style="width:250px;" class="text-input" /></td>
  </tr>
  <tr>
    <td>Select Patterns:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php for ($i=1; $i<31; $i++ ) { ?>
	<select name="pId<?php echo $i ?>" onChange="this.style.backgroundImage = this.options[this.selectedIndex].id;" style="width:150px; margin-top:2px; margin-bottom:2px; <?php if ( $i == 6  || $i == 11 || $i == 16  || $i == 21 || $i == 26 ) echo 'margin-left:133px;' ?> ">
	<option value="">No Pattern</option>
	<?php
	foreach ($pattrenData as $ck=>$cv){
	?>
	<option id="url(<?php echo 'media/pattrens/logo/'.$cv['logo'];?>)" style="background-image:url(<?php echo 'media/pattrens/logo/'.$cv['logo'];?>)" value="<?php echo $cv['Id']; ?>" <?php if($_SESSION['biz_pattren_pallet']==$cv['Id']) echo 'selected="selected"'; ?>><?php echo $cv['pcode_name']."_".$cv['name']; ?></option>
	<?php } ?>
	</select>&nbsp;
     <?php } ?>
	
	</td>
  </tr>
  <tr>
    <td style="padding-left:138px"><input type="submit" class="button" name="SavePattrenpallet" value="Add New Pattren Pallet" /></td>
  </tr>

</table>
</form>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td colspan="5">
	<?php 
		 $sql = "SELECT * from pattren_pallet";
		 //echo $sql;exit;
		 $result =@mysql_query($sql) or die ( mysql_error());
		 $total_pages = @mysql_num_rows($result);
		 echo "Total Pattren Pallets: ".$total_pages;
	?>  </tr>
  <tr>
  	<td colspan="5"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
  <tr>
    <td width="9%"><strong>Sr. Id</strong></td>
    <td width="27%"><strong>Pattern Pallet Name</strong></td>
    <td width="24%"><div align="left"><strong>Pattern Pallet</strong></div></td>	
    <td width="15%"><div align="center"><strong>Action</strong></div></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " ORDER BY Id DESC LIMIT ".$start.",".$limit;
		 $k=$k+$start;
		 
		 //echo $sql;exit;
		 $result = @mysql_query($sql);
		 $rec = array();
		 while( $row = @mysql_fetch_array($result) )
		 {
	
			?>
			  <tr>
				<td><?php echo ++$k;?> </td>
				<td><?php echo $row['name'];?> </td>
				<td>
				
				<div style="width:160px; height:51px;">
				<?php for ($i=1; $i<31; $i++ ) { 
					if ( $row['pId' .$i ] != '' ) {
				?>
				<?php echo $pattrenData[$row['pId' .$i ]]['code'];?>
				
				<div class="box_bg" style="background-image:url(<?php echo 'media/pattrens/logo/'.$pattrenData[$row['pId' .$i ]]['logo'];?>)"></div>
				
				 <?php 
					}
					} 
					?>
				</div>
				
				</td>
				<td align="center">
					<div align="center"><img src="images/edit.gif" style="cursor:pointer;" title="Edit Pattren Pallete" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='block'"  /> &nbsp;&nbsp;
				      <img src="images/dlt.gif" style="cursor:pointer;" title="Delete Pattren Pallete" alt="Delete Pattren Pallete" onclick="if(confirm('Are sure you want to delete')){window.location='process/process_pattren_pallets.php?action=d&Id=<?php echo $row["Id"]; ?>' }"  />				</div></td>
		      </tr>	
			  <tr>
			   <td colspan="5">
			   	<div id="<?php echo $row['Id'];?>" style="display:none; float:left; width:100%">
				<form action="<?php echo ruadmin; ?>process/process_pattren_pallets.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="Id" value="<?php echo $row['Id'];?>"  />
				<strong>Pattern Pallet Name:</strong>&nbsp;<input type="text" id="title" name="name"  value="<?php echo $row['name'];?>" class="text-input"/>
				&nbsp;<br />
				<strong>Select Pattern:</strong>
	<?php for ($i=1; $i<31; $i++ ) { ?>
	
	<select name="pId<?php echo $i ?>" onChange="this.style.backgroundImage = this.options[this.selectedIndex].id;" style="margin:5px 0px 0px 3px; <?php if ( $i == 6  || $i == 11 || $i == 16  || $i == 21 || $i == 26 ) echo 'margin-left:100px;' ?>; background-image:url(<?php echo 'media/pattrens/logo/'.$pattrenData[$row['pId'. $i ]]['logo'];?>); width:165px;">
	<option value="">No Pattern</option>
	 <?php
                    
	  foreach ( $pattrenData as $ck=>$cv){
	  
	  ?>
	<option id="url(<?php echo 'media/pattrens/logo/'.$cv['logo'];?>)" style="background-image:url(<?php echo 'media/pattrens/logo/'.$cv['logo'];?>)" value="<?php echo $cv['Id']; ?>" <?php if($row['pId'.$i]==$cv['Id']) echo 'selected="selected"'; ?>><?php echo $cv['pcode_name']."_".$cv['name']; ?></option>
	<?php } ?>
           </select>
    <?php } ?>
	<br />

				<input type="submit" name="UpdatePattrenpallet" class="button" style="margin:10px 0px 0px 100px;" value="Update Pattren Pallet" onclick="if(document.getElementById('title').value==''){alert('Enter Pattren Pallet Name'); return false;}" />&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='none'" class="button" />
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
<?php
unset ($_SESSION['biz_pattren_pallet_err']); 
?>