<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_OrderType'] = $_POST['OrderType'];
	$_SESSION['status']=$_POST['status'];
	
	header("location:".ruadmin."home.php?p=user_orders");exit;
}

$qryString ="u.userID = o.customerID";

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
	$_SESSION['em_SortBy'] = 'o.dated asc,o.orderID asc';
} 
//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px;">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='o.orderID' )  $t.=' selected="selected" ';
			$t.='value="o.orderID">Order Id</option>
			
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
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='u.first_name asc' )  $t.=' selected="selected" '; 			$t.=' value="u.first_name asc">First Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='u.first_name desc' )  $t.=' selected="selected" ';			$t.=' value="u.first_name desc">First Name Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='u.last_name asc' )  $t.=' selected="selected" '; 			$t.=' value="u.last_name asc">Last Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='u.last_name desc' )  $t.=' selected="selected" ';			$t.=' value="u.last_name desc">Last Name Desc</option>

			<option  ';	 if ($_SESSION['em_SortBy'] =='u.email asc' )  $t.=' selected="selected" '; 			$t.=' value="u.email asc">Email Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='u.email desc' )  $t.=' selected="selected" ';			$t.=' value="u.email desc">Email Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='o.dated asc' )  $t.=' selected="selected" ';			$t.=' value="o.dated asc">CreatedOn Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='o.dated desc' )  $t.=' selected="selected" ';			$t.=' value="o.dated desc">CreatedOn Desc</option>
			
			</select>
			<input type="hidden" name="status" value="'.$_SESSION['em_status'].'" />

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT o.*,u.* FROM ".tbl_order." as o, ".tbl_user." as u where $qryString $sortyby";  
	
	$sqlcount = "SELECT o.*,u.* FROM ".tbl_order." as o, ".tbl_user." as u where $qryString $sortyby"; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_OrderType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Orders Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Orders</h3>
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
					<td>
				  <?php 
						$qrycounts = mysql_query($sqlcount);
						$total_pages = mysql_num_rows($qrycounts);
						//$total_pages = $rowcounts[0];
						echo "Orders count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="10%"><strong>Order Number</strong></td>
					<td width="15%"><strong>Customer Name</strong></td>
					<td width="15%"><strong>Customer Email</strong></td>
					<td width="10%"><strong>Total Cash</strong></td>
					<td width="10%"><strong>Payment Method</strong></td>
					<td width="12%"><strong>Order Status</strong></td>
					<td width="18%"><div align="center"><strong>Date/Time</strong></div></td>																
					<td width="10%"><div align="center"><strong>Action</strong></div></td>
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
							<td><?php echo $items['orderID'];?> </td>
							<td><?php echo $items['first_name']." ".$items['last_name'];?> </td>
							<td><?php echo $items['email'];?> </td>
							<td><?php echo $items['total_cost'];?> </td>
							<td><?php if($items['payment_method'] == 'cash_stash') { echo "Cash Stash";} else if($items['payment_method'] == 'credit_card'){ echo "Credit Card";}?> </td>
							<td><?php if($items['ostatus'] == 'pending') { echo 'pending'; } else if($items['ostatus'] == 'shipped') { echo "Shipped";}?></td>		
							<td><div align="center"><?php echo $items['dated'];?></div></td>
                            <td valign="middle">
							  <div align="center">
							  <a href="<?php echo ruadmin; ?>home.php?p=view_order&orderID=<?php echo $items['orderID'];?>"><img src="images/order_icon.png" /></a>
		      <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_order.php?action=del_o&Id=<?php echo $items["orderID"];?>'}"  />&nbsp;&nbsp;</div></tr>				  
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
<?php unset($_SESSION['status']); ?>