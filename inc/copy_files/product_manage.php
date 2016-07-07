<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['category']=trim($_POST['category']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_ProductType'] = $_POST['ProductType'];
	header("location:".ruadmin."home.php?p=product_manage");exit;
}

$qryString =" where 1  ";

if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and ".$_SESSION['em_sType'] ." like '".$_SESSION['em_sText']."%'";
}
	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'proid asc';
}
if ( $_SESSION['category'] != '' )
{
	$qryString .= " and category like '%".$_SESSION['category']."%'";
}
//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px; text-align:left">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='pro_name' )  $t.=' selected="selected" ';
			$t.='value="pro_name">Product Name</option>
	
			<option ';
			if ($_SESSION['em_sType'] =='price' )  $t.=' selected="selected" ';
			$t.='value="price">Product Price</option>												
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='proid asc' )  $t.=' selected="selected" ';				$t.=' value="proid asc">New Product</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='proid desc' )  $t.=' selected="selected" ';				$t.=' value="proid desc">Old Product</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='pro_name asc' )  $t.=' selected="selected" '; 			$t.=' value="pro_name asc">Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='pro_name desc' )  $t.=' selected="selected" ';			$t.=' value="pro_name desc">Name Desc</option>
			</select>
			<input type="text" id="category" name="category" class="text-input" value="'.$_SESSION['category'].'" placeholder="Enter Category Name">
			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
echo	$sql = "SELECT * FROM ".tbl_product."  $qryString $sortyby ";  
	$sqlcount = "SELECT count(*) FROM ".tbl_product."  $qryString "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['category']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_ProductType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Product Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Product Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php echo $t;  ?>
		<?php if ( isset ($_SESSION['msg']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['msg']; unset($_SESSION['msg']); ?>
				</div>
			</div>	
		<?php } ?>				
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				   <tr>
					<td colspan="10" style="text-align:left">
				  <?php 
						$qrycounts = mysql_query($sqlcount);
						$rowcounts = mysql_fetch_array($qrycounts);
						$total_pages = $rowcounts[0];
						echo "Product count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="5%"><strong>Sr#</strong></td>
					<td width="17%"><strong>Product Name</strong></td>
					<td width="10%"><strong>Category</strong></td>
				   <td width="10%"><strong>Sub Category</strong></td>
                    <td width="10%"><strong>Price</strong></td>
					<td width="17%"><strong>Image</strong></td>
					<?php /*?><td width="14%"><div align="center"><strong>Status</strong></div></td>		<?php */?>																
					<td width="14%"><strong>Action</strong></td>
				  </tr>	
				  <?php 
					 ///////////////////////////////////////////////////////////////////////////////////////
					 include('common/pagingprocess.php');
					 ///////////////////////////////////////////////////////////////////////////////////////
					 $sql .=  " LIMIT ".$start.",".$limit;
					 $i=$i+$start;
					 $result = @mysql_query($sql);
					 $rec = array();
					 while( $row = @mysql_fetch_array($result) )
					 {
						$rec[] = $row;
					 }
					if(count($rec)>0)
					{
						foreach($rec as $items)
						{
						?>
						  <tr>
							<td><?php echo ++$i;?> </td>
							<td><?php echo $items['pro_name'];?> </td>
							<td><?php echo $items['category'];?> </td>
							<td><?php echo $items['sub_category'];?> </td>
                                   <td>$&nbsp;<?php echo $items['price'];?> </td>
                                   
							<?php /*?><td><img src="media/<?php echo $items['proid'];?>/product_image/thumb/<?php echo $items['image'];?>" height="70"/> </td>	<?php */?>
							<td class="list"><?php echo $items['image_code'];?></td>
							<?php /*?><td><div align="center"><?php if($items['status'] == '1')
							{
								echo "Active";
							} else 
							{
								echo "Inactive";
							}
							?></div></td><?php */?>
							<td>
							  <?php /*?><img src="images/edit.gif"  style="cursor:pointer; padding-left:60px;" title="Edit "   alt="Edit "   onClick="window.location='home.php?p=product_edit&Id=<?php echo $items["proid"];?>'"  /><?php */?>
							  <img src="images/dlt.gif"  style="cursor:pointer;"  title="Delete " alt="Delete " onclick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_product.php?action=d&Id=<?php echo $items["proid"];?>'}"  /></tr>
				  
						<?php
						}
					}
					?>	
				  <tr>
					<td  colspan="10"><?php include('common/paginglayout.php');?></td>
				  </tr>	     			
			</table>				
	</div>
</div>