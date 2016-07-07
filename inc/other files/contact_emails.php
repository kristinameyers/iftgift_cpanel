<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_ContactType'] = $_POST['ContactType'];
	header("location:".ruadmin."home.php?p=contact_emails");exit;
}

$qryString =" where 1  ";

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
			if ($_SESSION['em_sType'] =='name' )  $t.=' selected="selected" ';
			$t.='value="name">Contact Name</option>
	
			<option ';
			if ($_SESSION['em_sType'] =='email' )  $t.=' selected="selected" ';
			$t.='value="email">Contact Email</option>												
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='Id asc' )  $t.=' selected="selected" ';				$t.=' value="Id asc">Contact Id Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='Id desc' )  $t.=' selected="selected" ';				$t.=' value="Id desc">Contact Id Desc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='name asc' )  $t.=' selected="selected" '; 			$t.=' value="name asc">Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='email desc' )  $t.=' selected="selected" ';			$t.=' value="name desc">Name Desc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='email asc' )  $t.=' selected="selected" '; 			$t.=' value="email asc">Email Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='name desc' )  $t.=' selected="selected" ';			$t.=' value="email desc">Email Desc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='dated asc' )  $t.=' selected="selected" ';			$t.=' value="dated asc">CreatedOn Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='dated desc' )  $t.=' selected="selected" ';			$t.=' value="dated desc">CreatedOn Desc</option>
			
			</select>

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT * FROM `contact`  $qryString $sortyby ";  
	$sqlcount = "SELECT count(*) FROM `contact`  $qryString "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_ContactType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Contact Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Contact Management</h3>
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
						echo "Contact count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="10%"><strong>Id</strong></td>
					<td width="26%"><strong>Contact Name</strong></td>
					<td width="26%"><strong>Contact Email</strong></td>
					<td width="19%"><div align="center"><strong>Created</strong></div></td>																		
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
							<td><?php echo $items['name'];?> </td>
							<td><?php echo $items['email'];?> </td>	
							<td><div align="center"><?php echo $items['dated'];?> </div></td>
							<td valign="middle">
							  <div align="center">
							  <?php if($items['status']==1) { ?> 
							  <a href="<?php echo ruadmin; ?>home.php?p=read_contact&Id=<?php echo $items['Id']?>"><img src="images/read.png" title="View "   alt="View " width="28" ></a>&nbsp;&nbsp;
							   <?php } else { ?> 
							  <a href="<?php echo ruadmin; ?>home.php?p=read_contact&Id=<?php echo $items['Id']?>"><img src="images/unread.png" title="View "   alt="View " width="28"  /></a>&nbsp;&nbsp;
							   <?php } ?> 
							  
		      <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_contact.php?action=del_c&Id=<?php echo $items["Id"];?>'}" />&nbsp;&nbsp;</div></tr>
				  
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