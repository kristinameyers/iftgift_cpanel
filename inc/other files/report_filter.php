<?php

	


 /////////////////// collecting all pattern colors codes in form of array 
  			$pattrenData = array();
				$sqlbox1 = mysql_query("SELECT Id,name,pref_code,pcode_name	,logo,price from pattren  order by pcode_name");
				while($pattrenXZY   = mysql_fetch_array($sqlbox1)) 
				{
					$pattrenData[$pattrenXZY['Id']]['name'] =$pattrenXZY['name'];
					$pattrenData[$pattrenXZY['Id']]['pref_code'] =$pattrenXZY['pref_code'];
					$pattrenData[$pattrenXZY['Id']]['pcode_name'] =$pattrenXZY['pcode_name'];
					$pattrenData[$pattrenXZY['Id']]['logo'] =$pattrenXZY['logo'];
					$pattrenData[$pattrenXZY['Id']]['price'] =$pattrenXZY['price'];
					
					
				}
/////////////// end ///////////
	$sortyby = '  order by    orders.order_no desc ';
 $sql = "select order_no as OrderNo, orders.dated, orders.time, orders.fname, orders.time, orders.lname, orders.email, orders.phone, orders.address, orders.country, order_detail.qty,order_detail.price, order_detail.initialCharacters, product.name , order_detail.pattrenId 
FROM `orders`
JOIN order_detail ON order_detail.oId = orders.id
JOIN product ON product.Id=order_detail.pId where fname != ''  $sortyby "; 
 
 mysql_query("truncate `report` ");
 
 $result = @mysql_query($sql);
 while( $row = @mysql_fetch_array($result) )
  {
	  $orderNumber = $row['OrderNo'] ;
		if ( strlen($orderNumber ) == 4 ){
			$orderNumber =  'W-'. $orderNumber ;
			
		}elseif ( strlen($orderNumber ) == 3 ){
			$orderNumber =  'W-0'. $orderNumber ;
		}elseif ( strlen($orderNumber ) == 2 ){
			$orderNumber =  'W-00'. $orderNumber ;
		}elseif ( strlen($orderNumber ) == 1 ){
			$orderNumber =  'W-000'. $orderNumber ;
		}
		
		
		$pattrenIds = explode (',' , $row['pattrenId'] );
						
		for($i=0 ; $i<=5 ; $i++ ) 
		{
			$row['cc_'. $i] = ' ';
			
			if ($pattrenData[$pattrenIds[$i]]  ) $row['cc_'. $i] =$pattrenData[$pattrenIds[$i]]['pcode_name'];
			
		}	
		
         if($row['country'] == 'Kuwait'){
			                     			     
                               
			$total = (($row['qty']*$row['price']) + 3);
		 }else{
			 
			$total	= $row['qty']*$row['price'];
		 }
		
   mysql_query ("
		INSERT INTO `report` 
		set `order_no` = '". addslashes( $orderNumber) ."', 
		`dated` = '". addslashes($row['dated'] ) ."', 
		`time` = '". addslashes( $row['time'] ) ."',
		 `fname` = '".addslashes( $row['fname'] ) ."', 
		 `lname` = '".addslashes( $row['lname'] ) ."', 
		 `cus_email` = '".addslashes( $row['email'] ) ."', 
		 `con_no` = '".addslashes( $row['phone'] ) ."', 
		 `item` = '".addslashes( $row['name'] ) ."', 
		 `qty` = '".addslashes( $row['qty'] ) ."', 
		 `ptn_1` = '".addslashes( $row['cc_0'] ) ."',
		  `ptn_2` = '".addslashes( $row['cc_1'] ) ."', 
		  `ptn_3` = '".addslashes( $row['cc_2'] ) ."', 
		  `ptn_4` = '".addslashes( $row['cc_3'] ) ."',
		   `ptn_5` = '".addslashes( $row['cc_4'] ) ."', 
		 `ptn_6` = '".addslashes( $row['cc_5'] ) ."', 
		 `address` = '".addslashes( $row['address'] )."', 
		 `initials` = '".addslashes( $row['initialCharacters'] ) ."',
		  `country` = '".addslashes( $row['country'] )."',
		  `total_price` = '$total'" );



		
		$srNo++;
	}
	
$srNo=0;

if ( isset ($_POST['doSearch'] ) ) 
{
	foreach ($_POST as $k =>  $v )
	{
		$_SESSION['sfilter'][$k]= addslashes( trim($v));	
	}
	header("location:".ruadmin."home.php?p=report_filter");exit;
}elseif ( isset ($_POST['doClear'] ) ) 
{
	$_SESSION['sfilter'] = array();
}


	$qryString  = " where 1";
	
if ( isset ($_SESSION['sfilter']) )
	

foreach ($_SESSION['sfilter'] as $k =>  $v )
	{
		if ($v != '' and $k!='doSearch')
		{
			if ( in_array ( $k , array('ptn_1','ptn_2','ptn_3','ptn_4','ptn_5','ptn_6') )  ) {
				$qryString .= " and  ( ptn_1  like '". $v."%' or  ptn_2  like '". $v."%' or  ptn_3  like '". $v."%' or  ptn_4  like '". $v."%' or  ptn_5  like '". $v."%'  or  ptn_6  like '". $v."%' ) ";	
				
			}else{
				$qryString .= " and ". $k ." like '". $v."%'";	
			}
			
		}
	}


//-------------------------------------------------------------------------
$t ='
<form method="post" action="">
  <table cellpadding="0" cellspacing="0"  style="border:1px solid #DDDDDD; padding:4px; width:700px !important ">
    <tr>
      
	<td    ><strong> First Name:&nbsp;</strong></td>
       
      <td   >  <input type="text" id="fname" name="fname" class="text-input" value="'.$_SESSION['sfilter']['fname'].'"  autocomplete="off"  ></td>
      <td   ><strong> Last Name:&nbsp;</strong></td>
      
       <td > <input type="text" id="lname" name="lname" class="text-input" value="'.$_SESSION['sfilter']['lname'].'"  autocomplete="off"  ></td>
    </tr>
	
	<tr>
     <td    ><strong> Customer Email:&nbsp;</strong></td>
	  
      <td    >  <input type="text" id="cus_email" name="cus_email" class="text-input" value="'.$_SESSION['sfilter']['cus_email'].'" autocomplete="off" ></td>
       <td    ><strong> Customer Contact:&nbsp;</strong></td>
	   <td > 
        
        <input type="text" id="con_no" name="con_no" class="text-input" value="'.$_SESSION['sfilter']['con_no'].'" autocomplete="off" ></td>
    </tr>
	
	<tr>
      <td    ><strong> Address :&nbsp;</strong></td>
	   <td >
       
        <input type="text" id="address" name="address" class="text-input" value="'.$_SESSION['sfilter']['address'].'" autocomplete="off"  ></td>
      <td    ><strong> Country :&nbsp;</strong></td>
	   <td >
        
        <input type="text" id="country" name="country" class="text-input" value="'.$_SESSION['sfilter']['country'].'" autocomplete="off"  ></td>
    </tr>
	<tr>
      <td    ><strong> Date :&nbsp;</strong></td>
	   <td > 
       
        <input type="text" id="dated" name="dated" class="text-input" value="'.$_SESSION['sfilter']['dated'].'" autocomplete="off"  ></td>
     <td    ><strong> Time :&nbsp;</strong></td> 
	 <td >
        
        <input type="text" id="time" name="time" class="text-input" value="'.$_SESSION['sfilter']['time'].'" autocomplete="off"  ></td>
    </tr>
	
	
	<tr>
      <td    ><strong> Order No :&nbsp;</strong></td>
	   <td >
       
        <input type="text" id="order_no" name="order_no" class="text-input" value="'.$_SESSION['sfilter']['order_no'].'" autocomplete="off"  ></td>
      <td    ><strong> Product Name</strong></td>
	   <td > <input type="text" id="item" name="item" class="text-input" value="'.$_SESSION['sfilter']['item'].'" autocomplete="off"  ></td>
	   
    </tr>
	
		<tr>
			<td    ><strong> Ptn-1:&nbsp;</strong></td>
			<td ><input type="text" id="ptn_1" name="ptn_1" class="text-input" value="'.$_SESSION['sfilter']['ptn_1'].'" autocomplete="off"  ></td>
			<td    ><strong> Ptn-2: </strong></td>
			<td ><input type="text" id="ptn_2" name="ptn_2" class="text-input" value="'.$_SESSION['sfilter']['ptn_2'].'" autocomplete="off"  ></td>
		
		</tr>
		
		<tr>
			<td    ><strong> Ptn-3: &nbsp;</strong></td>
			<td ><input type="text" id="ptn_3" name="ptn_3" class="text-input" value="'.$_SESSION['sfilter']['ptn_3'].'" autocomplete="off"  ></td>
			<td    ><strong> Ptn-4: &nbsp;</strong></td>
			<td ><input type="text" id="ptn_4" name="ptn_4" class="text-input" value="'.$_SESSION['sfilter']['ptn_4'].'" autocomplete="off"  ></td>
		
		</tr>
		
		<tr>
			<td    ><strong> Ptn-5: &nbsp;</strong></td>
			<td ><input type="text" id="ptn_6" name="ptn_5" class="text-input" value="'.$_SESSION['sfilter']['ptn_5'].'" autocomplete="off"  ></td>
			<td    ><strong> Ptn-6: &nbsp;</strong></td>
			<td ><input type="text" id="ptn_6" name="ptn_6" class="text-input" value="'.$_SESSION['sfilter']['ptn_6'].'" autocomplete="off"  ></td>
		
		</tr>
	<tr>
	<tr>
			<td colspan="4"    ><strong> (Patterns - C, D, M, MC, T, F, P, S , V )</strong></td>
		
		</tr>
	<tr>
	
      
      <td colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="submit" style="margin-left:159px;" class="button" name="doClear" id="doClear" value="Clear"   /> 
	  
	  <input type="submit" style="margin-left:40px;" class="button" name="doSearch" id="doSearch" value="Search"   /> 
	  ';
	 // if ( isset (  $_SESSION['sfilter']  ) ) {
	  $t.='<a href="'. ruadmin .'inc/download_report.php" style="margin-left:39px;  padding:3px 10px 3px 10px !important;" class="button" >Download Report </a>';
//	  }
	  $t.='</td>
	 
    </tr>
   
  
	  
   
    
  </table>
</form>
';
	$sortyby = '  order by report.order_no desc ';
	 $sql = "select *  FROM report $qryString $sortyby "; 

	
	$sqlcount = "select count(*) FROM `report` $qryString $sortyby "; 
 	
?>
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
    <table width="200%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px">
				   <tr>
					<td  colspan="18" >
				  <?php 
						$qrycounts = mysql_query($sqlcount);
						$rowcounts = mysql_fetch_array($qrycounts);
						$total_pages = $rowcounts[0];
						echo "Orders count: ".$total_pages;
					?>				  </tr>			
                   

				  <tr>
                  <td  ><strong>#</strong></td>
                  <td  ><strong>Order Number</strong></td>
                  <td  ><strong>Date</strong></td>
                  <td  ><strong>Time</strong></td>
                  <td  ><strong>First Name /Last Name</strong></td>
                  <td  ><strong>Customer Email</strong></td>
                  <td  ><strong>Contact Number</strong></td>
                  <td  ><strong>Item</strong></td>
                  <td  ><strong>Qty</strong></td>
                  <td  ><strong>Ptn-1</strong></td>
                  <td  ><strong>Ptn-2</strong></td>
                  <td  ><strong>Ptn-3</strong></td>
                  <td  ><strong>Ptn-4</strong></td>
                  <td  ><strong>Ptn-5</strong></td>
                  <td  ><strong>Ptn-6</strong></td>

                  <td  ><strong>Initials</strong></td>
                  
                  <td  ><strong>Delivery Address</strong></td>                  
                   <td  ><strong>Delivery/<br>Country</strong></td> 
                  <td  ><strong>Total Price</strong></td> 
                  
					
					
				  </tr>	
				  <?php 
					 ///////////////////////////////////////////////////////////////////////////////////////
					  $limit =  100;
					  include('common/pagingprocess.php');
					 ///////////////////////////////////////////////////////////////////////////////////////
					 $sql .=  " LIMIT ".$start.",".$limit;
					 $i=$i+$start;
					
					 $result = @mysql_query($sql);
					 $rec = array();
		$orderflag	 = '';	
		  $srNo =1;
	while( $row = @mysql_fetch_array($result) )
	{	
		
		if ( $orderflag != $row['order_no'] )
		{
		?>
		<tr>
							<td><?php echo  $srNo;?> </td>
							<td><?php echo $row['order_no']; ?> </td>
							<td><?php echo $row['dated'];?> </td>	
                            <td><?php echo $row['time'];?> </td>	
                            <td><?php echo $row['fname'] .' '.$row['lname'];?> </td>	

                            <td><?php echo $row['cus_email'];?> </td>	
                            <td><?php echo $row['con_no'];?> </td>	
                            <td nowrap="nowrap"><?php echo $row['item'];?> </td>	
                            <td><?php echo $row['qty'];?> </td>
                            <td><?php echo $row['ptn_1'];?> </td>
                            <td><?php echo $row['ptn_2'];?> </td>
                            <td><?php echo $row['ptn_3'];?> </td>
                            <td><?php echo $row['ptn_4'];?> </td>
                            <td><?php echo $row['ptn_5'];?> </td>
                            <td><?php echo $row['ptn_6'];?> </td>

                            <td><?php echo $row['initials'];?> </td>
                            
                            <td><?php echo $row['address'];?> </td>
                            
                            <td><?php echo $row['country'];?> </td>
                            <td> <?php echo $row['total_price']."KD";?> </td>
                            

                            
							
							  			  </tr>
                                          
		 <?php 
		
		}else{
?>	<tr>
							<td><?php echo  $srNo;?> </td>
							
							<td> </td>	
                            <td> </td>	
                            <td> </td>	
                            <td> </td>	
                            <td> </td>	
                            <td> </td>	
                           <td nowrap="nowrap"><?php echo $row['item'];?> </td>	
                            <td><?php echo $row['qty'];?> </td>
                            <td><?php echo $row['ptn_1'];?> </td>
                            <td><?php echo $row['ptn_2'];?> </td>
                            <td><?php echo $row['ptn_3'];?> </td>
                            <td><?php echo $row['ptn_4'];?> </td>
                            <td><?php echo $row['ptn_5'];?> </td>
                            <td><?php echo $row['ptn_6'];?> </td>

                           <td><?php echo $row['initials'];?> </td>
                            <td>  </td>
                            <td>  </td>
                             <td> <?php echo $row['total_price']."KD";?> </td>

                            
							
							  			  </tr>
                                          <?php 
			
		
		}
		$orderflag = $row['order_no'];
		$srNo++;
	}
	
					
					?>	
				  <tr>
					<td   colspan="18" ><?php include('common/paginglayout.php');?></td>
				  </tr>	     			
			</table>
  </div>
</div>
<script type="text/javascript" >
	
	
	$( "#fname" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=fname",      minLength: 2    });
	$( "#lname" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=lname",      minLength: 2    });
	$( "#cus_email" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=cus_email",      minLength: 2    });
	$( "#con_no" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=con_no",      minLength: 2    });
	$( "#address" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=address",      minLength: 2    });
	$( "#country" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=country",      minLength: 2    });
	$( "#item" ).autocomplete({      source: "<?php echo ruadmin ?>/inc/search.php?f=item",      minLength: 2    });
	
	
	
	
</script>