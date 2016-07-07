<?php
if(isset($_GET['orderID']) && $_GET['orderID'] != '') {
	$orderId = $_GET['orderID'];
	$Stsquery = "select * from ".tbl_order." where orderID = '".$orderId."'";
	$Stsorders = $db->get_row($Stsquery,ARRAY_A);
	$get_cus = $db->get_row("select first_name,last_name,email from ".tbl_user." where userId = '".$Stsorders['customerID']."'",ARRAY_A);
	$get_shp = $db->get_row("select * from ".tbl_shipping_address." where orderID = '".$orderId."'",ARRAY_A);
	
	$query = "select * from ".tbl_order_detail." where orderID = '".$orderId."'";
	$orders = $db->get_results($query,ARRAY_A);
}
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_OrderType'] = $_POST['OrderType'];
	$_SESSION['status']=$_POST['status'];
	
	header("location:".ruadmin."home.php?p=view_order");exit;
}

$qryString =" where orderID = '".$orderId."'";

/*if(isset($_SESSION['em_status']))
{
	
 $qryString .="  and status = '".$status."'";

}*/


if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and ".$_SESSION['em_sType'] ." like '".$_SESSION['em_sText']."%'";
}
	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'o.dated desc,o.orderID desc';
} 
//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px;">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='transactionID' )  $t.=' selected="selected" ';
			$t.='value="transactionID">Transaction Id</option>
			
			<option ';
			if ($_SESSION['em_sType'] =='s.cus_fname' )  $t.=' selected="selected" ';
			$t.='value="s.cus_fname">First Name</option>
			
			<option ';
			if ($_SESSION['em_sType'] =='s.cus_lname' )  $t.=' selected="selected" ';
			$t.='value="s.cus_lname">Last Name</option>
	
			<option ';
			if ($_SESSION['em_sType'] =='s.cus_email' )  $t.=' selected="selected" ';
			$t.='value="s.cus_email">Email</option>												
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='o.orderID asc' )  $t.=' selected="selected" ';				$t.=' value="o.orderID asc">Order Id Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='o.orderID desc' )  $t.=' selected="selected" ';				$t.=' value="o.orderID desc">Order Id Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='c.cus_fname asc' )  $t.=' selected="selected" '; 			$t.=' value="c.cus_fname asc">First Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='c.cus_fname desc' )  $t.=' selected="selected" ';			$t.=' value="c.cus_fname desc">First Name Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='recp_last_name asc' )  $t.=' selected="selected" '; 			$t.=' value="recp_last_name asc">Last Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='recp_last_name desc' )  $t.=' selected="selected" ';			$t.=' value="recp_last_name desc">Last Name Desc</option>

			<option  ';	 if ($_SESSION['em_SortBy'] =='recp_email asc' )  $t.=' selected="selected" '; 			$t.=' value="recp_email asc">Email Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='recp_email desc' )  $t.=' selected="selected" ';			$t.=' value="recp_email desc">Email Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='dated asc' )  $t.=' selected="selected" ';			$t.=' value="dated asc">CreatedOn Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='dated desc' )  $t.=' selected="selected" ';			$t.=' value="dated desc">CreatedOn Desc</option>
			
			</select>
			<input type="hidden" name="status" value="'.$_SESSION['em_status'].'" />

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	//$sql = "SELECT o.*,s.* FROM ".tbl_order." as o, ".tbl_shipping_address." as s where s.orderID = o.orderID $sortyby";  
	
	$sqlcount = "SELECT count(*) FROM ".tbl_order_detail."  $qryString "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_OrderType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Orders Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>View Order</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php //echo $t;  ?>
	<script type="text/javascript">
		function order_status(oId) {
			var order_status = document.getElementById("ostatus");
			var strStatus = order_status.options[order_status.selectedIndex].value;
			//alert(strStatus);
			$.ajax({
				url : "<?php echo ruadmin;?>process/process_order.php?order_id="+oId+"&status="+strStatus,
				type: "GET",
				dataType:'html',
				success:function(response)
				{
					window.location = "<?php echo ruadmin; ?>home.php?p=view_order&orderID="+oId;
				}
			});	
		}
	</script>	
		<?php if ( isset ($_SESSION['order_view']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['order_view'];  ?>
				</div>
			</div>	
		<?php } ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr style="background-color:#FFFFFF">
				<td style="float:left"><strong><?php echo ucfirst($get_cus['first_name']).'&nbsp;'.ucfirst($get_cus['last_name']).'&nbsp;-&nbsp;Order # '.$orderId; ?></strong></td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left"><strong>Order Status : <?php echo ucfirst($Stsorders['ostatus']); ?></strong></td>
				</tr>
				<tr><td></td></tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left; font-size:16px" colspan="4">
				<fieldset><strong>Customer Information :</strong></fieldset>
				</td>
				<td style="float:right; font-size:16px;margin-right: 300px;">
				<fieldset><strong>Payment Information :</strong></fieldset>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>Customer Name :</strong> <?php echo ucfirst($get_cus['first_name']).'&nbsp;'.ucfirst($get_cus['last_name']); ?>
				</td>
				<td style="float:right;margin-right: 312px;">
				<strong>Payment Method :</strong> <?php echo ucwords(str_replace('_',' ',$Stsorders['payment_method'])); ?>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>Customer Enail :</strong> <?php echo $get_cus['email']; ?>
				</td>
				<td style="float:right;margin-right: 284px;">
				<strong>Payment Date :</strong> <?php echo $Stsorders['dated']; ?>
				</td>
				</tr>
				<tr><td></td></tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left; font-size:16px">
				<fieldset><strong>Shipping Address :</strong></fieldset>
				</td>
				<td style="float:right; font-size:16px;margin-right: 370px;">
				<fieldset><strong>Order Detail :</strong></fieldset>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>Name :</strong> <?php echo ucfirst($get_shp['cus_fname']).'&nbsp;'.ucfirst($get_shp['cus_lname']); ?>
				</td>
				<td style="float:right;margin-right: 360px;">
				<strong>Number of Items :</strong> <?php echo $Stsorders['num_of_item']; ?>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>Address 1 :</strong> <?php echo $get_shp['cus_address']; ?>
				</td>
				<td style="float:right; margin-right: 357px;">
				<strong>Net Amount :</strong> $<?php echo $Stsorders['net_amount']; ?>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>Address 2 :</strong> <?php echo $get_shp['ship_address2']; ?>
				</td>
				<td style="float:right; margin-right: 395px;">
				<strong>Total :</strong> <?php echo $Stsorders['total_cost']; ?>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>Zip :</strong> <?php echo $get_shp['ship_zip']; ?>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>City :</strong> <?php echo $get_shp['ship_city']; ?>
				</td>
				</tr>
				<tr style="background-color:#FFFFFF">
				<td style="float:left">
				<strong>State :</strong> <?php echo $get_shp['ship_state']; ?>
				</td>
				</tr>
				<tr><td></td></tr>
		</table>						
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr class="alt-row">
					<td><strong>Order Status</strong>:&nbsp;</td>
						<td><select id="ostatus" onchange="order_status('<?php echo $orderId;?>')">
							<option value="pending" <?php if($Stsorders['ostatus'] == 'pending') echo 'selected="selected"'; ?>>Pending</option>
							<option value="shipped" <?php if($Stsorders['ostatus'] == 'shipped') echo 'selected="selected"'; ?>>Shipped</option>
							</select>
						</td>
				</tr>	
				   <tr>
					<td>
				  <?php 
						$qrycounts = mysql_query($sqlcount);
						$rowcounts = mysql_fetch_array($qrycounts);
						$total_pages = $rowcounts[0];
						echo "Product count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="10%"><strong>SNo.</strong></td>
					<td width="22%"><strong>Product Name</strong></td>
					<td width="15%"><strong>Price</strong></td>
					<td width="15%"><strong>vendor</strong></td>
					<td width="10%"><strong>Quantity</strong></td>
					<td width="18%"><div align="center"><strong>Date/Time</strong></div></td>																
					<?php /*?><td width="10%"><div align="center"><strong>Action</strong></div></td><?php */?>
				  </tr>	
				  <?php 
					 ///////////////////////////////////////////////////////////////////////////////////////
					 include('common/pagingprocess.php');
					 ///////////////////////////////////////////////////////////////////////////////////////
					 $query .=  " LIMIT ".$start.",".$limit;
					 $i=$i+$start;
					
					 $result = @mysql_query($query);
					 $rec = array();
					 while( $row = @mysql_fetch_array($result) )
					 {
						$rec[] = $row;
					 }
					if(count($rec)>0)
					{
						foreach($rec as $items)
						{
							$product = $db->get_row("select pro_name,price,vendor from ".tbl_product." where proid = '".$items['product_id']."'",ARRAY_A);
						?>
						  <tr>
							<td><?php echo ++$i;?> </td>
							<td><?php echo $product['pro_name'];?> </td>
							<td><?php echo $product['price'];?> </td>
							<td><?php echo $product['vendor'];?> </td>
							<td><?php echo $items['pro_qty'];?></td>		
							<td><div align="center"><?php echo $items['dated'];?></div></td>
                           <?php /*?> <td valign="middle">
							  <div align="center">
		      <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_order.php?action=del_od&Id=<?php echo $items["orderdID"];?>&orderId=<?php echo $items['orderID'];?>'}"  />&nbsp;&nbsp;</div></tr>	<?php */?>			  
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
<?php unset($_SESSION['status']); 
unset($_SESSION['order_view']);
?>