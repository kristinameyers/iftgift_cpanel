<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.8.21/themes/ui-lightness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo ru_css; ?>jquery-ui-timepicker-addon.css" />
<meta charset="utf-8" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="<?php echo ru_js ?>newjquery-ui-timepicker-addon.js"></script>
<script>
    $(function() {
        $( "#datedText" ).datepicker();
		$.datepicker.setDefaults({
        dateFormat: 'yy-mm-dd',
	 });
	
	   
});
    $(function() {
		 $('#timeText').timepicker();
		   
});
    </script>
<?php
if ( isset ($_POST['doSearch'] ) ) 
{
	foreach ($_POST as $k =>  $v )
	{
		$_SESSION['search'][$k]= $v;	
	}
	$_SESSION['fname_sType']=$_POST['fnameType'];
	$_SESSION['fname_sText']=trim($_POST['fnameText']);
	$_SESSION['lname_sType']=$_POST['lnameType'];
	$_SESSION['lname_sText']=trim($_POST['lnameText']);
	$_SESSION['email_sType']=$_POST['emailType'];
	$_SESSION['email_sText']=trim($_POST['emailText']);
	$_SESSION['dated_sType']=$_POST['datedType'];
	$_SESSION['dated_sText']=trim($_POST['datedText']);
	$_SESSION['time_sType']=$_POST['timeType'];
	$_SESSION['time_sText']=trim($_POST['timeText']);
	$_SESSION['ord_SortBy']=$_POST['SortBy'];
	header("location:".ruadmin."home.php?p=report");exit;
}


$qryString =" where 1 and fname != '' ";



if ( $_SESSION['fname_sText'] != '')
{
	$qryString .= " and ".$_SESSION['fname_sType'] ." like '".$_SESSION['fname_sText']."%'";
}

elseif ( $_SESSION['lname_sText'] != '')
{
	$qryString .= " and ".$_SESSION['lname_sType'] ." like '".$_SESSION['lname_sText']."%'";
}

elseif ( $_SESSION['email_sText'] != '')
{
	$qryString .= " and ".$_SESSION['email_sType'] ." like '".$_SESSION['email_sText']."%'";
}

elseif ( $_SESSION['dated_sText'] != '')
{
	$qryString .= " and ".$_SESSION['dated_sType'] ." like '".$_SESSION['dated_sText']."%'";
}

elseif ( $_SESSION['time_sText'] != '')
{
	$qryString .= " and ".$_SESSION['time_sType'] ." like '".$_SESSION['time_sText']."%'";
}

	
if ( !isset($_SESSION['ord_SortBy']))
{
	$_SESSION['ord_SortBy'] = 'dated desc';
}

//-------------------------------------------------------------------------
$t ='
<form method="post" action="">
  <table cellpadding="0" cellspacing="0" width="600"  style="border:1px solid #DDDDDD; padding:4px; ">
    <tr>
      <tr>
      <td    ><strong> Order No :&nbsp;</strong></td>
	   <td >
       
        <input type="text" id="orderText" name="orderText" class="text-input" value="'.$_SESSION['order_sText'].'"></td>
      <td    ><strong> Initial :&nbsp;</strong></td>
	   <td >
        
        <input type="text" id="initialText" name="initialText" class="text-input" value="'.$_SESSION['initial_sText'].'"></td>
    </tr>
	<td    ><strong> First Name:&nbsp;</strong></td>
       
      <td   >  <input type="text" id="fnameText" name="fnameText" class="text-input" value="'.$_SESSION['fname_sText'].'"></td>
      <td   ><strong> Last Name:&nbsp;</strong></td>
      
       <td > <input type="text" id="lnameText" name="lnameText" class="text-input" value="'.$_SESSION['lname_sText'].'"></td>
    </tr>
	
	<tr>
     <td    ><strong> Customer Email:&nbsp;</strong></td>
	  
      <td    >  <input type="text" id="emailText" name="emailText" class="text-input" value="'.$_SESSION['email_sText'].'"></td>
       <td    ><strong> Customer Contact:&nbsp;</strong></td>
	   <td > 
        
        <input type="text" id="phoneText" name="phoneText" class="text-input" value="'.$_SESSION['phone_sText'].'"></td>
    </tr>
	
	<tr>
      <td    ><strong> Address :&nbsp;</strong></td>
	   <td >
       
        <input type="text" id="addressText" name="addressText" class="text-input" value="'.$_SESSION['address_sText'].'"></td>
      <td    ><strong> Country :&nbsp;</strong></td>
	   <td >
        
        <input type="text" id="countryText" name="countryText" class="text-input" value="'.$_SESSION['country_sText'].'"></td>
    </tr>
	<tr>
      <td    ><strong> Date :&nbsp;</strong></td>
	   <td > 
       
        <input type="text" id="datedText" name="datedText" class="text-input" value="'.$_SESSION['date_sText'].'"></td>
     <td    ><strong> Time :&nbsp;</strong></td> 
	 <td >
        
        <input type="text" id="timeText" name="timeText" class="text-input" value="'.$_SESSION['time_sText'].'"></td>
    </tr>
	
	
	<tr>
      <td >  &nbsp;Sort&nbsp;By:
      <select name="SortBy" style="margin-left:7px;" >
    
      <option  ';	 if ($_SESSION['ord_SortBy'] =='Id asc' )  $t.=' selected="selected" ';				$t.=' value="Id asc">Order Id Asc</option>
			<option  ';	 if ($_SESSION['ord_SortBy'] =='Id desc' )  $t.=' selected="selected" ';				$t.=' value="Id desc">Order Id Desc</option>
			
			<option  ';	 if ($_SESSION['ord_SortBy'] =='fname asc' )  $t.=' selected="selected" '; 			$t.=' value="fname asc">First Name Asc</option>
			<option  ';	 if ($_SESSION['ord_SortBy'] =='fname desc' )  $t.=' selected="selected" ';			$t.=' value="fname desc">First Name Desc</option>
			
			<option  ';	 if ($_SESSION['ord_SortBy'] =='lname asc' )  $t.=' selected="selected" '; 			$t.=' value="lname asc">Last Name Asc</option>
			<option  ';	 if ($_SESSION['ord_SortBy'] =='lname desc' )  $t.=' selected="selected" ';			$t.=' value="lname desc">Last Name Desc</option>

			<option  ';	 if ($_SESSION['ord_SortBy'] =='email asc' )  $t.=' selected="selected" '; 			$t.=' value="email asc">Email Asc</option>
			<option  ';	 if ($_SESSION['ord_SortBy'] =='email desc' )  $t.=' selected="selected" ';			$t.=' value="email desc">Email Desc</option>
			
			<option  ';	 if ($_SESSION['ord_SortBy'] =='dated asc' )  $t.=' selected="selected" ';			$t.=' value="dated asc">CreatedOn Asc</option>
			<option  ';	 if ($_SESSION['ord_SortBy'] =='dated desc' )  $t.=' selected="selected" ';			$t.=' value="dated desc">CreatedOn Desc</option>
			
			<option  ';	 if ($_SESSION['ord_SortBy'] =='time asc' )  $t.=' selected="selected" ';			$t.=' value="time asc">Time Asc</option>
			<option  ';	 if ($_SESSION['ord_SortBy'] =='time desc' )  $t.=' selected="selected" ';			$t.=' value="time desc">Time Desc</option>
			
			</select>
			 </td >
			 </tr>
	<tr>
      <td > <input type="submit" style="margin-left:159px;" class="button" name="doSearch" id="doSearch" value="Filter Listing"   />
      <td > <a href="'. ruadmin .'inc/download_report.php" style="margin-left:39px; padding:1px 10px 1px 10px !important;" class="button" >Download Report </a></td>
    </tr>
   
  
	  
   
    
  </table>
</form>
';
	$sortyby = '  order by '.$_SESSION['ord_SortBy'];
	$sql = "SELECT * FROM `orders`  $qryString $sortyby "; 
 	$sqlcount = "SELECT count(*) FROM `orders`  $qryString "; 	
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Search in Reports</a></h3>
<div class="content-box">
  <div class="content-box-header">
    <h3>Search in Reports</h3>
    <div class="clear"></div>
  </div>
  <div class="content-box-content"> <?php echo $t;  ?>
    <?php if ( isset ($_SESSION['msg']) ) {?>
    <div class="notification error png_bg"> <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
      <div> <?php echo  $_SESSION['msg']; unset($_SESSION['msg']); ?> </div>
    </div>
    <?php } ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="10"><?php 
						$qrycounts = mysql_query($sqlcount);
						$rowcounts = mysql_fetch_array($qrycounts);
						$total_pages = $rowcounts[0];
						echo "Orders count: ".$total_pages;
					?>
      </tr>
      <tr>
        <td width="10%"><strong>Id</strong></td>
        <td width="26%"><strong>Customer Name</strong></td>
        <td width="20%"><strong>Customer Email</strong></td>
        <td width="15%"><div align="center"><strong>Date</strong></div></td>
        <td width="10%"><div align="center"><strong>Time</strong></div></td>
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
        <td><?php echo ++$i;?></td>
        <td><?php echo $items['fname']." ".$items['lname'];?></td>
        <td><?php echo $items['email'];?></td>
        <td><div align="center"><?php echo $items['dated'];?> </div></td>
        <td><div align="center"><?php echo $items['time'];?> </div></td>
        <td valign="middle"><div align="center">
            <?php if($items['status']==1) { ?>
            <a href="<?php echo ruadmin; ?>home.php?p=read_order&Id=<?php echo $items['Id']?>"><img src="images/read.png" title="View "   alt="View" width="28"/></a>&nbsp;&nbsp;
            <?php } else { ?>
            <a href="<?php echo ruadmin; ?>home.php?p=read_order&Id=<?php echo $items['Id']?>"><img src="images/unread.png" title="View "   alt="View"  width="28"/></a>&nbsp;&nbsp;
            <?php } ?>
            <img src="images/dlt.gif"  style="cursor:pointer;" title="Delete " alt="Delete " onClick="if(confirm('Are sure you want to delete')){ window.location='<?php echo ruadmin; ?>process/process_contact.php?action=del_o&Id=<?php echo $items["Id"];?>'}"  />&nbsp;&nbsp; </div>
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
