<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_OrderType'] = $_POST['OrderType'];
	$_SESSION['status']=$_POST['status'];
	
	header("location:".ruadmin."home.php?p=withdraw_cashstash");exit;
}

//$qryString ="1";

$qryString ="w.userId = u.userId";

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
	$_SESSION['em_SortBy'] = 'w.dated desc,w.withdrawID desc';
}

//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px;">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='first_name' )  $t.=' selected="selected" ';
			$t.='value="first_name">First Name</option>
			
			<option ';
			if ($_SESSION['em_sType'] =='last_name' )  $t.=' selected="selected" ';
			$t.='value="last_name">Last Name</option>
	
			<option ';
			if ($_SESSION['em_sType'] =='email' )  $t.=' selected="selected" ';
			$t.='value="email">Email</option>												
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='withdrawID asc' )  $t.=' selected="selected" ';				$t.=' value="withdrawID asc">Order Id Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='withdrawID desc' )  $t.=' selected="selected" ';				$t.=' value="withdrawID desc">Order Id Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='first_name asc' )  $t.=' selected="selected" '; 			$t.=' value="first_name asc">First Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='first_name desc' )  $t.=' selected="selected" ';			$t.=' value="first_name desc">First Name Desc</option>
			
			<option  ';	 if ($_SESSION['em_SortBy'] =='last_name asc' )  $t.=' selected="selected" '; 			$t.=' value="last_name asc">Last Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='last_name desc' )  $t.=' selected="selected" ';			$t.=' value="last_name desc">Last Name Desc</option>

			<option  ';	 if ($_SESSION['em_SortBy'] =='email asc' )  $t.=' selected="selected" '; 			$t.=' value="email asc">Email Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='email desc' )  $t.=' selected="selected" ';			$t.=' value="email desc">Email Desc</option>
			
			</select>
			<input type="hidden" name="status" value="'.$_SESSION['em_status'].'" />

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	
	if( isset ($_GET['cid'] ) and  trim( $_GET['cid']) != '') {
		$cid = $_GET['cid'];
		//if($cid==0){ $cid = ""; }
		$filterby .= " and  w.wstatus = '".$cid."'" ;
	}
	
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT w.*,u.* FROM ".tbl_withdrawcash." as w, ".tbl_user." as u where $qryString $filterby $sortyby";  
	
	$sqlcount = "SELECT w.*,u.* FROM ".tbl_withdrawcash." as w, ".tbl_user." as u where $qryString $filterby $sortyby"; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_OrderType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Withdraw Cashstash</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Withdraw Cashstash</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php echo $t;  ?>
		<?php if ( isset ($_SESSION['withdrawmsg']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['withdrawmsg']; unset($_SESSION['withdrawmsg']); ?>
				</div>
			</div>	
		<?php } ?>				
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				   <tr>
					<td colspan="10" style="text-align:left">
				  <?php 
						$qrycounts = mysql_query($sqlcount);
						$total_pages = mysql_num_rows($qrycounts);
						//$total_pages = $rowcounts[0];
						echo "Orders count: ".$total_pages;
					?>				 
					<div style="float:right; margin-right:5px;">
     Filter By Status: <select name="cid" id="cid"  onChange="{window.location='home.php?p=withdraw_cashstash&cid=' + this.value}" >
				<option  value="" >---------Filter by Status-------------</option>
				<option value="pending" <?php if($cid == 'pending') echo 'selected="selected"'; ?>>Pending</option>
				<option value="approved" <?php if($cid == 'approved') echo 'selected="selected"'; ?>>Approved</option>
		  </select>
          </div> </td>
					</tr>			
				  <tr>
					<td width="2%"><strong>SNo.</strong></td>
					<td width="15%"><strong>Customer Name</strong></td>
					<td width="10%"><strong>Customer Email</strong></td>
					<td width="15%"><strong>Payment Method</strong></td>
					<td width="10%"><strong>Total Cash</strong></td>
					<td width="10%"><strong>Withdraw Status</strong></td>
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
							<td><?php echo ++$i;?> </td>
							<td><?php echo $items['first_name']." ".$items['last_name'];?> </td>
							<td><?php echo $items['email'];?> </td>
							<td><?php if($items['payment_method'] == 'bank_account') { echo "Bank Account"; } else { echo "Credit Card";}?> </td>
							<td><?php echo $items['total_price'];?> </td>
							<td><?php echo $items['wstatus'];?></td>		
							<td><div align="center"><?php echo $items['dated'];?>&nbsp;&nbsp; <?php echo $items['time'];?> </div></td>
                            <td valign="middle">
							  <div align="center">
				<img src="images/edit.gif"  style="cursor:pointer;" title="Edit Record" onclick="document.getElementById('<?php echo $items['withdrawID'];?>').style.display='block'"  />	&nbsp;&nbsp;			  
		      <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_withdrawcash.php?action=del_o&Id=<?php echo $items["withdrawID"];?>'}"  />&nbsp;&nbsp;</div></tr>				  
				  </tr>
				  <tr>
			   <td colspan="8"><div id="<?php echo $items['withdrawID'];?>" style="display:none;">
			   <form action="<?php echo ruadmin; ?>process/process_withdrawcash.php" method="post">
				<select name="wstatus" id="wstatus" style="margin-left:500px;">
				<option value="approved" <?php if($items['wstatus'] == 'approved') echo 'selected="selected"'; ?>>Approved</option>
				<option value="pending" <?php if($items['wstatus'] == 'pending') echo 'selected="selected"'; ?>>Pending</option>
				</select>
				<input type="hidden" id="withdrawID" name="withdrawID"  value="<?php echo $items['withdrawID'];?>"/>
				<input type="submit" class="button" name="editwithdraw" value="Update"  />
				&nbsp;<input type="button"  class="button" value="Cancel" onclick="document.getElementById('<?php echo $items['withdrawID'];?>').style.display='none'"  />
				</form>
				</div>
			  </td> 
			  </tr>
			  <?php
						}
					}
					?>	
					<td  colspan="10"><?php include('common/paginglayout.php');?></td>
				  </tr>	     			
			</table>				
	</div>
</div>
<?php unset($_SESSION['withdrawmsg']); ?>