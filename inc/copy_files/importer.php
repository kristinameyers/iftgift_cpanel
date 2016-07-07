<?php
if (isset($_POST['Importer'])){ 
unset($_SESSION['import_err']);
	    unset($_SESSION['import']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['import'][$k]=$v;
	}
  	$flgs = false;

	
	$file_names = $_FILES['uploadedfile']['name'];
	$ext = pathinfo($file_names, PATHINFO_EXTENSION);
		$fsize = $_FILES['uploadedfile']['size']; 
		if($file_names==''){
			$_SESSION['import_err']['file_names'] = "Please Select a CSV File to Import";
			$flgs = true;
		}
		else if(strtolower($ext) == "csv" && $fsize<='1048576'){ 
			$a		=	'correct_format';	 
			$fname	=	$file_names;
		}else{ 
			$_SESSION['import_err']['file_names'] = "File is not in csv format or size exceed from 1 MB";
			$flgs = true;
		}	
	
	if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=importer'); exit;
		
  }	
}

if(isset($_POST['update']) && $_POST['update']=='1'){
foreach($_POST['col'] as $k=> $v)
	{
			$field = 'f'.($k+1);
		
			if($v!='')
			{
				$user_selected_headers[$field] = trim($v);
			}
	}
	
	$data_selected=''; 
	foreach($user_selected_headers as $k=>$v){
		$data_selected.=', '.$k;
	}
	 $data_selected=ltrim($data_selected,',');
	
	$sub_query = '';
	$PRefix_query = '';
	
		
		$res=mysql_query("select  $data_selected from temp_products where dated = '".$_SESSION['uploade_time']."'");
		$totalnumber_rows = @mysql_num_rows($res);
		
		$remaining_Data = false;

		while ($row = mysql_fetch_array($res)){
			//echo '<pre>';print_r($row);
			
		foreach(array_count_values($user_selected_headers) as $val => $c)
    	if($c > 1) {
			$dups[] = $val;
		} 
		$toaldublicte_col='';
		if(count($dups)>0){
			$toaldublicte_col_foll=count($dups);
			$_SESSION['import_err']['msg']= " You Have Selected Duplicate Column Name From Dropdown. Please Correct It And Try Again";
		}	
			
			
			$category = explode(":",$row[4]);
			$pcategory = mysql_real_escape_string(stripslashes(trim($category[0])));
			$subcategory = mysql_real_escape_string(stripslashes(trim($category[1])));
			$query = mysql_query("insert into ".tbl_product." set image_code='".$row[0]."', vendor='".mysql_real_escape_string(stripslashes(trim($row[1])))."',pro_name='".mysql_real_escape_string(stripslashes(trim($row[2])))."',price='".mysql_real_escape_string(stripslashes(trim($row[3])))."',category='".$pcategory."',sub_category='".$subcategory."',gender='".preg_replace('/\s+/', '',str_replace(' ', '',mysql_real_escape_string(stripslashes(trim($row[5])))))."',userId='".$_SESSION['cp_cmd']['userId']."'");
		}
	$_SESSION['import_errs']['msg'] = "File successfully uploaded";	
	header('location:'.ruadmin.'home.php?p=importer'); exit;
}
?>
<h3><a href="<?php echo ruadmin; ?>home.php?p=importer">Importer</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Importer</h3>
		<div class="clear"></div>
	</div>
	
	<div class="content-box-content">
  <?php if ( isset ($_SESSION['import_err']) ) {?>
		<div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php foreach ($_SESSION['import_err'] as $ek=>$ev ) echo $ev ."<br />"; ?>
			</div>
		</div>	
  <?php } else if ( isset ($_SESSION['import_errs']['msg']) ) { ?>
  <div class="notification error png_bg">
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php echo $_SESSION['import_errs']['msg']; ?>
			</div>
		</div>	
  <?php
  }unset ($_SESSION['import_err']);
  unset($_SESSION['import_errs']['msg']);
   ?>
	<div id="main">
	<?php 
	 if($a=='correct_format')
	  {
	  	ini_set("auto_detect_line_endings", true);
	  	 $filename = $_FILES['uploadedfile']['tmp_name'];
		 $handle = fopen($filename, "r");
       
		 $count = 0 ;
		 $data_arr = array();
		 $time = $_SESSION['uploade_time']  = time();
 
	if (($data = fgetcsv($handle))  !== FALSE ) {
	
		$fields = array();
		for($i=1;$i<=count($data); $i++) {
				$f='f'.$i;
				$fields[] = '`'.$f.'` VARCHAR(500) NOT NULL ';	
		}
		 	mysql_query("DELETE FROM temp_products");
		 	//mysql_query ("CREATE TABLE  temp_products  ( `dated` VARCHAR(50) NOT NULL , " . implode(', ', $fields) . ") ENGINE = InnoDB");
		}
		while (($data = fgetcsv($handle,1000, ',', '"')) !== FALSE)
         {
			$check_empty_row = false;
			$numcols = count($data);
		
			
			if($numcols>0)
			{
				
				$qry_temp = "INSERT INTO temp_products SET dated='".$time."' ";
				$data = array_map('mysql_real_escape_string', $data); 
		
				foreach($data as $dK => $dV)
			 	{
					if($check_empty_rows == false && $dV!='')
					{
						$check_empty_row = true;
					}
					
					$f_post = $dK + 1;	
					if($f_post <= $numcols)
					{
						$data[$dK]=stripslashes(trim($dV));
						$data[$dK]=str_replace('"',' ',$data[$dK]);
				 		$data[$dK]= addslashes(trim($data[$dK]));
						$qry_temp .= " , f".$f_post."='".$data[$dK]."'";	
					}	
				}
				
			}
			if($check_empty_row)
			{
				 @mysql_query($qry_temp);
			}
			
		}

			$option = 	"<option value=''>select</option>
						<option value='pro_name'>Product Name</option>
						<option value='price'>Price</option>
						<option value='image_code'>Image</option>
						<option value='vendor'>Vendor</option>
						<option value='category'>Category</option>
						<option value='sub_category'>Sub Category</option>
						<option value='gender'>Gender</option>".$str;
	   
	  ?>
	  <form name="update" method="post" action="<?php echo ruadmin.'home.php?p=importer';?>" enctype="multipart/form-data">
        <input type="hidden" name="update" value="1" />
		<div style="width:100%; overflow:auto;">
        <table width="1200px" border="0" cellpadding="0" cellspacing="0">
          <tr>
          	<?php  
			$totalheader = $numcols;
			if($totalheader<7)
			{
				$totalheader = $numcols+1;
			}
			 for($col =1; $col <= $totalheader ; $col++ ) 
			 { 
			 ?>
			 <th width="5%" scope="col"><select class="select_input" name="col[]" id="col_<?php echo $col ?>" >
              <?php  echo $option; 
			   ?>
			</select></th>
             <?php } ?> 
          </tr>
         <?php  

		 $qtylength='';
		   for($lengthcol =1; $lengthcol < $totalheader ; $lengthcol++ ) 
			 {
		  		$qtylength .= " +IF( f".$lengthcol." = '' || f".$lengthcol." = ' ', 0, 1)";
			}
			
			
		$codeQry = "SELECT * FROM temp_products where dated = '$time'
								ORDER BY ($qtylength) DESC LIMIT 5";
		$codeQrys=mysql_query($codeQry);
		
		while($data = @mysql_fetch_array($codeQrys))
		{
			//echo '<pre>';print_r($data);exit;
				echo  '<tr>';
				for($f_display=1;$f_display <= $totalheader; $f_display++)
				{
					$colon=":";
					if($f_display=='5'){
						$fdata=explode(":",$data[$f_display]);
							echo '<td scope="col" class="list">'.($fdata[0]).'</td>';
							echo '<td scope="col" class="list">'.($fdata[1]).'</td>';
						}else{
							echo '<td scope="col" class="list">'.($data[$f_display]).'</td>';
						}
					
					//echo '<td scope="col" style="width:70px">'.($data[$f_display]).'</td>';
				}
					echo '</tr>';	
					
			}
		
	 ?>
          <tr>
            <td colspan="<?php echo $totalheader+2; ?>" style="text-align:left">	
			<input type="hidden"  name="file_name" value="<?php echo $fname; ?>" />
			
			<input type="submit" class="submit"   onclick="search_business();" name="Submit"  value="Update" /></td>
          </tr>
        </table>
		</div>
      </form>
	  <?php } else {
	  ?>
		<form  method="post" action="<?php echo ruadmin; ?>home.php?p=importer" enctype="multipart/form-data">
			<fieldset>
				
				<p><label>Import CSV File:</label><input type="file" name="uploadedfile" id="uploadedfile" class="text-input small-input" /></p>
				
				<p style="width:100%">
				<input type="submit" class="button" value="Save" name="Importer" id="submit" />
				</p>
			</fieldset>
		</form>
	<?php } ?>	
		</div>
	</div>
</div>
<?php
unset($_SESSION['import_err']);
unset($_SESSION['import']);
?>