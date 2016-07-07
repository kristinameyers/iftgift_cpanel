<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_ProductType'] = $_POST['ProductType'];
	header("location:".ruadmin."home.php?p=staff_manage");exit;
}

$qryString =" where 1 and type = 's'";

if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and ".$_SESSION['em_sType'] ." like '".$_SESSION['em_sText']."%'";
}
	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'userId desc';
}

//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px; text-align:left">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='first_name' )  $t.=' selected="selected" ';
			$t.='value="first_name">User Name</option>								
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='userId desc' )  $t.=' selected="selected" ';				$t.=' value="userId desc">New User</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='userId asc' )  $t.=' selected="selected" ';				$t.=' value="userId asc">Old User</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='first_name asc' )  $t.=' selected="selected" '; 			$t.=' value="first_name asc">First Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='first_name desc' )  $t.=' selected="selected" ';			$t.=' value="first_name desc">First Name Desc</option>
			
			</select>

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT * FROM ".tbl_user." $qryString $sortyby ";  
	$sqlcount = "SELECT count(*) FROM ".tbl_user."  $qryString "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_ProductType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Staff Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Staff Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php echo $t;  ?>
		<?php if ( isset ($_SESSION['member_update_errs']['useraddeds']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['member_update_errs']['useraddeds']; unset($_SESSION['member_update_errs']['useraddeds']); ?>
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
						echo "Member count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="5%"><strong>Sr#</strong></td>
					<td width="17%"><strong>User Name</strong></td>
                    <td width="10%"><strong>Email</strong></td>
					<td width="10%"><strong>Status</strong></td>																	
					<td width="8%"><div align="center"><strong>Action</strong></div></td>
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
							<td><?php echo $items['username'];?> </td>
                            <td><?php echo $items['email'];?> </td>
							<td>
							<?php if($items['status'] == '1')
							{
								echo "Active";
							} else 
							{
								echo "Inactive";
							}
							?> </td>
							<td>
							  <img src="images/edit.gif"  style="cursor:pointer; padding-left:60px;" title="Edit "   alt="Edit "   onClick="window.location='home.php?p=member_edit&userId=<?php echo $items["userId"];?>' "/>&nbsp;<img src="images/dlt.gif"  style="cursor:pointer; padding-right:50px;" align="right" title="Delete " alt="Delete " onclick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_member.php?action=delluser&userId=<?php echo $items["userId"];?>'}"  /></td></tr>
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