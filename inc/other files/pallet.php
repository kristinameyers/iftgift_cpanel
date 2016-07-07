<script type="text/javascript" src="jspallet.js"></script>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Color Pallet Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Color Pallet Management</h3>
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
<form action="<?php echo ruadmin; ?>process/process_pallets.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #DDDDDD;">
 <tr>
    <td><strong>Add New Color Pallet</strong>
	   <?php if ( isset ($_SESSION['biz_pallet_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['biz_pallet_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } ?> </td>										
  </tr>
  <?php 
  $colorData = array();
  $sqlcolor = mysql_query(" SELECT * from color  ORDER BY ref_code ,code_name ");
	while($resultcolor   = mysql_fetch_array($sqlcolor))
	{
		$colorData[$resultcolor['Id']] = $resultcolor;
	}
	
?>
  <tr>
    <td>Pallet Name:&nbsp;&nbsp;&nbsp;
      <input name="name" type="text" id="name" style="width:250px;" class="text-input" /></td>
  </tr>

  <tr>
    <td>Select Colors:&nbsp;
	<?php for ($i=1; $i<31; $i++ ) { ?>
     
     	<select name="cId<?php echo $i ?>" onChange="this.style.backgroundColor = this.options[this.selectedIndex].id;" style="width:165px;   <?php if ( $i == 6  || $i == 11 || $i == 16 || $i == 21 || $i == 26 ) echo 'margin-left:90px; margin-top:5px;' ?> ">
		<option value="">No Color</option>
		<?php
	
			foreach ( $colorData as $ck=>$cv){
			?>
			<option id="#<?php echo $cv['code']; ?>" style="background-color:#<?php echo $cv['code']; ?>" value="<?php echo $cv['Id']; ?>" <?php if($_SESSION['biz_pallet']==$cv['Id']) echo 'selected="selected"'; ?>><?php echo $cv['code_name']."_".$cv['name'].' (#'.$cv['code'].')'; ?></option>
			<?php } ?>
			</select>&nbsp;
     <?php } ?>
              
	
	</td>
  </tr>
  <tr>
    <td style="padding-left:90px"><input type="submit" class="button" name="Savepallet" value="Add New Pallet" /></td>
  </tr>

</table>
</form>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
    <td colspan="5">
	<?php 
		 $sql = "SELECT * from pallet";
		 //echo $sql;exit;
		 $result =@mysql_query($sql) or die ( mysql_error());
		 $total_pages = @mysql_num_rows($result);
		 echo "Total pallets: ".$total_pages;
	?>  </tr>
  <tr>
  	<td colspan="5"><?php echo $_SESSION['statuss']; unset($_SESSION['statuss']);?></td>
  </tr>
  <tr>
    <td width="9%"><strong>Sr. Id</strong></td>
    <td width="27%"><strong>Pallet Name</strong></td>
    <td width="24%"><div align="left"><strong>Pallet</strong></div></td>	
    <td width="15%"><div align="center"><strong>Action</strong></div></td>
  </tr>	
  
    <?php 
		 ///////////////////////////////////////////////////////////////////////////////////////
		 include('common/pagingprocess.php');
		 ///////////////////////////////////////////////////////////////////////////////////////
		 $sql .=  " ORDER BY Id DESC LIMIT ".$start.",".$limit;
		 $i=$i+$start;
		 //echo $sql;exit;
		 $result = @mysql_query($sql);
		 $rec = array();
		 $k =1;
		 while( $row = @mysql_fetch_array($result) )
		 {
	
			?>
			  <tr>
				<td><?php echo $k++;?> </td>
				<td><?php echo $row['name'];?> </td>
				<td>
				
				<div style="width:160px; height:51px;">
                    <?php for ($i=1; $i<31; $i++ ) { 
					if ( $row['cId' .$i ] != '' ) {
				?>
					<div class="box_bg" style="background-color:#<?php echo $colorData[$row['cId' .$i ]]['code'];?>;"></div>
                    <?php 
					}
				} ?>
				
				</div>
				</td>
				<td align="center">
					<div align="center"><img src="images/edit.gif" style="cursor:pointer;" title="Edit pallete" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='block'"  /> &nbsp;&nbsp;
				      <img src="images/dlt.gif" style="cursor:pointer;" title="Delete pallete" alt="Delete pallete" onclick="if(confirm('Are sure you want to delete')){window.location='process/process_pallets.php?action=d&Id=<?php echo $row["Id"]; ?>' }"  />				</div></td>
		      </tr>	
			  <tr>
			   <td colspan="5">
			   	<div id="<?php echo $row['Id'];?>" style="display:none; float:left; width:100%">
				<form action="<?php echo ruadmin; ?>process/process_pallets.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="Id" value="<?php echo $row['Id'];?>"  />
				<strong>Pallet Name:</strong>&nbsp;<input type="text" id="title" name="name"  value="<?php echo $row['name'];?>" class="text-input"/>
				&nbsp;<br />
				<strong>Select Color:</strong>
                    
                    <?php for ($i=1; $i<31; $i++ ) { ?>
     
                         <select name="cId<?php echo $i ?>"style="margin-top:5px; background-color:#<?php echo $colorData[$row['cId'. $i ]]['code']; ?>; width:165px;  <?php if ( $i == 6  || $i == 11 || $i == 16  || $i == 21 || $i == 26 ) echo 'margin-left:85px;' ?> " onChange="this.style.backgroundColor = this.options[this.selectedIndex].id;">
                         
                          
                         <option value="">No Color</option>
                         <?php
                    
                              foreach ( $colorData as $ck=>$cv){
                              ?>
                              <option id="#<?php echo $cv['code']; ?>" style="background-color:#<?php echo $cv['code']; ?>" value="<?php echo $cv['Id']; ?>" <?php if($row['cId'.$i]==$cv['Id']) 			echo 'selected="selected"'; ?>><?php echo $cv['code_name']."_".$cv['name'].' (#'.$cv['code'].')'; ?></option>
                              <?php } ?>
                              </select>&nbsp;
                    <?php } ?>
     
                    
	
				<input type="submit" name="Updatepallet" class="button" value="Update pallet" onclick="if(document.getElementById('title').value==''){alert('Enter pallet Name'); return false;}" style="margin:10px 0px 0px 84px;"/>&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $row['Id'];?>').style.display='none'" class="button"  />
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
unset ($_SESSION['biz_pallet_err']); 
?>