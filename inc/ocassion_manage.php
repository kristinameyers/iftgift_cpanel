<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_ProductType'] = $_POST['ProductType'];
	header("location:".ruadmin."home.php?p=ocassion_manage");exit;
}

$qryString =" where 1 and p_occasionid != 0 ";

if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and ".$_SESSION['em_sType'] ." like '".$_SESSION['em_sText']."%'";
}
	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'occasionid desc';
}

//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px; text-align:left;">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='occasion_name' )  $t.=' selected="selected" ';
			$t.='value="occasion_name">Ocassion Name</option>								
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='occasionid desc' )  $t.=' selected="selected" ';				$t.=' value="occasionid desc">New Ocassion</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='occasionid asc' )  $t.=' selected="selected" ';				$t.=' value="occasionid asc">Old Ocassion</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='occasion_name asc' )  $t.=' selected="selected" '; 			$t.=' value="occasion_name asc">Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='occasion_name desc' )  $t.=' selected="selected" ';			$t.=' value="occasion_name desc">Name Desc</option>
			
			</select>

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';				
	if( isset ($_GET['cid'] ) and  trim( $_GET['cid']) != '') {
		$cid = $_GET['cid'];
		if($cid==0){ $cid = ""; }
		$filterby .= " and  p_occasionid = ".$cid ;
	}
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT * FROM ".tbl_occasion." $qryString $filterby $sortyby";  
	$sqlcount = "SELECT count(*) FROM ".tbl_occasion."  $qryString $filterby "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_ProductType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Ocassion Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Ocassion Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php echo $t;  ?>
		<?php if ( isset ($_SESSION['biz_ocs_errs']['ocassions']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['biz_ocs_errs']['ocassions']; unset($_SESSION['biz_ocs_errs']['ocassions']); ?>
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
						echo "Ocassion count: ".$total_pages;
					?>				 			
		 <div style="float:right; margin-right:5px; margin-top:10px;">
     Filter By Category: <select name="cid" id="cid"  onChange="{window.location='home.php?p=ocassion_manage&cid=' + this.value}" >
				<option  value="" >---------List by Category-------------</option>
				<?php 
		
		 $sqlInds = "SELECT  occasionid, occasion_name  from ".tbl_occasion." where p_occasionid = 0 and occasion_type=1";
		 $resultInds =@mysql_query($sqlInds);
		 while ($rowInds = mysql_fetch_array( $resultInds ) ){ 
		 	$sel = '  ';

		 	if ( $cid == $rowInds	['occasionid'] ) $sel = ' Selected = "Selected" ';
			echo '	<option  value="'.$rowInds['occasionid'].'" '.$sel.' >'.$rowInds['occasion_name'].' </option>';

		 }
		  ?>
		 
		  </select>
          </div> 
		  </tr>			
				  <tr>
					<td width="2%"><strong>Sr#</strong></td>
					<td width="10%"><strong>Ocassion Name</strong></td>
					<td width="10%"><strong>Related Categories</strong></td>
					<td width="10%"><strong>Group</strong></td>
					<td width="1%"><strong>Status</strong></td>																	
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
							<td><?php echo $items['occasion_name'];?> </td>
							<td><?php  if($items['cat_id'] != '') { 
									echo $items['cat_id'];
								} else {
									echo "All Categories";
								}
							?> </td>
                            <?php
								$pcat = mysql_query("select * from ".tbl_occasion." where occasionid = ".$items['p_occasionid']." and p_occasionid = 0"); 
								while($parent = mysql_fetch_array($pcat))
								{
							?>
							<td><?php echo $parent['occasion_name'];?> </td>
							<?php } ?>
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
							  <img src="images/edit.gif"  style="cursor:pointer; padding-left:60px;" title="Edit "   alt="Edit "   onClick="window.location='home.php?p=ocassion_edit&occasionid=<?php echo $items["occasionid"];?>' "  />&nbsp;<img src="images/dlt.gif"  style="cursor:pointer; padding-right:50px;" align="right" title="Delete " alt="Delete " onclick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_ocassion.php?action=d&Id=<?php echo $items["occasionid"];?>'}"  /></td></tr>
				 
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