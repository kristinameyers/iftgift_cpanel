<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_sType']=$_POST['sType'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_ProductType'] = $_POST['ProductType'];
	header("location:".ruadmin."home.php?p=category_manage");exit;
}

$qryString =" where 1 and p_catid = 0 ";

if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and ".$_SESSION['em_sType'] ." like '".$_SESSION['em_sText']."%'";
}
	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'catid desc';
}

//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="border:1px solid #DDDDDD; padding:4px; text-align:left;">
		<form method="post" action="">
			&nbsp;Search:&nbsp;<select name="sType" id="sType" onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_sType'] =='cat_name' )  $t.=' selected="selected" ';
			$t.='value="cat_name">Category Name</option>								
		
			</select>&nbsp;
			<input type="text" id="sText" name="sText" class="text-input" value="'.$_SESSION['em_sText'].'">
			&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy" onchange="document.getElementById(\'sText\').focus()">
			<option  ';	 if ($_SESSION['em_SortBy'] =='catid desc' )  $t.=' selected="selected" ';				$t.=' value="catid desc">New Category</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='catid asc' )  $t.=' selected="selected" ';				$t.=' value="catid asc">Old Category</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='cat_name asc' )  $t.=' selected="selected" '; 			$t.=' value="cat_name asc">Name Asc</option>
			<option  ';	 if ($_SESSION['em_SortBy'] =='cat_name desc' )  $t.=' selected="selected" ';			$t.=' value="cat_name desc">Name Desc</option>
			
			</select>

			&nbsp;<input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing"   /></form>			
				
		</td>
	</tr>	
	</table>';
	$sortyby = '  order by '.$_SESSION['em_SortBy'];
	$sql = "SELECT * FROM ".tbl_category." $qryString $sortyby ";  
	$sqlcount = "SELECT count(*) FROM ".tbl_category."  $qryString "; 
	unset($_SESSION['em_sType']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['em_ProductType']);
	
?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Category Management</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>Category Management</h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">		
		<?php echo $t;  ?>
		<?php if ( isset ($_SESSION['biz_cat_errs']['categories']) ) {?>
			<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php echo  $_SESSION['biz_cat_errs']['categories']; unset($_SESSION['biz_cat_errs']['categories']); ?>
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
						echo "Category count: ".$total_pages;
					?>				  </tr>			
				  <tr>
					<td width="5%"><strong>Sr#</strong></td>
					<td width="17%"><strong>Category Name</strong></td>
                    <td width="5%"><strong>Sort Order</strong></td>
					<?php /*?><td width="5%"><strong>Occassion</strong></td><?php */?>
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
							<td><?php echo $items['cat_name'];?> </td>
                            <td><?php echo $items['sortorder'];?> </td>
							<?php /*?><td><?php $accos = json_decode($items['ocassionid'],true);
								if($accos) {
								foreach($accos as $as => $bs)
								{
									$string .= $bs['occassionid'].',';
												
								}		
									echo $data = substr(trim($string), 0, -1);	
									}
							?> </td><?php */?>
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
							  <img src="images/edit.gif"  style="cursor:pointer; padding-left:60px;" title="Edit "   alt="Edit "   onclick="document.getElementById('<?php echo $items['catid'];?>').style.display='block'"  />&nbsp;<img src="images/dlt.gif"  style="cursor:pointer; padding-right:50px;" align="right" title="Delete " alt="Delete " onclick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_category.php?action=d&Id=<?php echo $items["catid"];?>'}"  /></td></tr>
				  <tr>
			   <td colspan="7">
			   	<div id="<?php echo $items['catid'];?>" style="display:none; float:left; width:100%; text-align:left">
				<form action="<?php echo ruadmin; ?>process/process_category.php" method="post">
				<input type="hidden" name="catid" value="<?php echo $items['catid'];?>"  />
				<strong>Category Name:</strong>&nbsp;<input type="text" id="cat_name" name="cat_name"  value="<?php echo $items['cat_name'];?>" class="text-input" style="width:120px;"/>
				&nbsp;
				<strong>Category Group:</strong>
   				<input type="checkbox" name="you_cat" id="you_cat" value="1" <?php if($items['you_cat'] == '1') echo 'checked="checked"'; ?> />You Category <input type="checkbox" name="sjester" id="sjester" value="2" <?php if($items['sjester'] == '2') echo 'checked="checked"'; ?>/>s'Jester
				&nbsp;
				<strong>Sort Order:</strong>&nbsp;<input name="sortorder" type="text" id="sortorder" value="<?php echo $items['sortorder'];?>" class="text-input" style="width:70px;"/> 
				&nbsp;
                    <?php /*?><strong>Occassions:</strong>&nbsp;
					<select name="occassion[]" id="occassion" multiple="multiple">
					<?php
					$occassion = mysql_query("SELECT occasionid,occasion_name from ".tbl_occasion." where occasion_type = 1 and status = 1");
					while($poccas = mysql_fetch_array($occassion)){
					?>
					<option style="font-weight:bold; color:#000000" disabled="disabled"><?php echo $poccas['occasion_name']; ?></option>
					<?php 
					$catOccas = mysql_query("SELECT occasionid, occasion_name from ".tbl_occasion." where p_occasionid = ".$poccas['occasionid']." and status = 1");
                	while($short = mysql_fetch_array($catOccas)){?>
				<option value="<?php echo $short['occasionid']; ?>" <?php if($items['ocassionid']==$short['occasionid']) { echo 'selected="selected"';}?> style="margin-left:20px;" ><?php echo $short['occasion_name']; ?></option>
				<?php }	} ?>
					</select><?php */?>
					
				&nbsp;
				&nbsp;
                    <strong>Status:</strong>&nbsp;
					<select name="status" id="status">
					<option value="1" <?php if($items['status'] == '1') echo 'selected="selected"'; ?>>Active</option>
					<option value="0" <?php if($items['status'] == '0') echo 'selected="selected"'; ?>>Inactive</option>
					</select>
				&nbsp;
				<input type="submit" name="Updatecategory" class="button" value="Update"/>&nbsp;<input type="button" value="Cancel" onclick="document.getElementById('<?php echo $items['catid'];?>').style.display='none'" class="button"  />
				</form>
				</div>			  </td> 
			  </tr>
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