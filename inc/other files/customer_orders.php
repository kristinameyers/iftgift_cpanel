<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_OrderType'] = $_POST['OrderType'];
	header("location:".ruadmin."home.php?p=customer_orders");exit;
}

$qryString =" where 1 and status = '0' and fname != '' ";

if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and ".$_SESSION['em_sType'] ." like '".$_SESSION['em_sText']."%'";
}
	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'Id asc';
}

//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px;">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='fname' )  $t.=' selected="selected" ';
			$t.='value="fname">First Name</option>
			
			<option ';
			if ($_SESSION['em_sType'] =='lname' )  $t.=' selected="selected" ';
			$t.='value="lname">Last Name</option>
	
			<option ';
			if ($_SESSION['em_sType'] =='email' )  $t.=' selected="selected" ';
			$t.='value="email">Email</option>												
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='Id asc' )  $t.=' selected="selected" ';				$t.=' value="Id asc">Order Id Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='Id desc' )  $t.=' selected="selected" ';				$t.=' value="Id desc">Order Id Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='fname asc' )  $t.=' selected="selected" '; 			$t.=' value="fname asc">First Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='fname desc' )  $t.=' selected="selected" ';			$t.=' value="fname desc">First Name Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='lname asc' )  $t.=' selected="selected" '; 			$t.=' value="lname asc">Last Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='lname desc' )  $t.=' selected="selected" ';			$t.=' value="lname desc">Last Name Desc</option>

			<option  ';	 if ($_SESSION['em_SortBy'] =='email asc' )  $t.=' selected="selected" '; 			$t.=' value="email asc">Email Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='email desc' )  $t.=' selected="selected" ';			$t.=' value="email desc">Email Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='dated asc' )  $t.=' selected="selected" ';			$t.=' value="dated asc">CreatedOn Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='dated desc' )  $t.=' selected="selected" ';			$t.=' value="dated desc">CreatedOn Desc</option>
			
			</select>

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT * FROM `orders`  $qryString $sortyby ";  
	$sqlcount = "SELECT count(*) FROM `orders`  $qryString "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_OrderType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Orders Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Orders Management</h3>
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
					<td colspan="10">
				  <?php 
						$qrycounts = mysql_query($sqlcount);
						$rowcounts = mysql_fetch_array($qrycounts);
						$total_pages = $rowcounts[0];
						echo "Orders count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="10%"><strong>Id</strong></td>
					<td width="26%"><strong>Customer Name</strong></td>
					<td width="26%"><strong>Customer Email</strong></td>
					<td width="19%"><div align="center"><strong>Date/Time</strong></div></td>																		
					<td width="19%"><div align="center"><strong>Action</strong></div></td>
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
							<td><?php echo $items['fname']." ".$items['lname'];?> </td>
							<td><?php echo $items['email'];?> </td>	
							<td><div align="center"><?php echo $items['dated'];?> </div></td>
							<td valign="middle">
							  <div align="center">
							  
							  <a href="<?php echo ruadmin; ?>home.php?p=read_order&Id=<?php echo $items['Id']?>"><img src="images/unread.png" title="View "   alt="View"  width="28"/></a>&nbsp;&nbsp;
				
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