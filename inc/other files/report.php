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
  
  $(function()
  {
		 $('#timeText').timepicker();
		   
  });
    </script>
<?php

	$qryString =" where fname != '' ";


	$sortyby = '    order by    orders.order_no desc ';

	 $sql = "select orders.order_no as OrderNo, orders.dated, orders.time, orders.fname, orders.time, orders.lname, orders.email, orders.phone, orders.address, orders.country, order_detail.qty,order_detail.price ,order_detail.initialCharacters, product.name , order_detail.pattrenId 
FROM `orders`
JOIN order_detail ON order_detail.oId = orders.id
JOIN product ON product.Id=order_detail.pId $qryString $sortyby "; 
	
	$sqlcount = "select count(*) FROM `orders` JOIN order_detail ON order_detail.oId = orders.id JOIN product ON product.Id=order_detail.pId $qryString $sortyby "; 



?>

<h3><a href="#">Home</a> &raquo; <a href="#" class="active">View Order Reports</a></h3>
<div class="content-box">
	<div class="content-box-header">
			<h3>View Order Reports</h3>
            <h3  style="float:right;" >
    <a href="<?php echo ruadmin ?>inc/download_report2.php" style="margin-left:39px; padding:3px 10px 3px 10px !important;" class="button" >Download Report </a></h3>
    
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
	  $orderNumber = $row['OrderNo'];
	               
					  
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
		
		if ( $orderflag != $row['OrderNo'] )
		{
		?>
		<tr>
							<td><?php echo  $srNo;?> </td>
							<td><?php echo $orderNumber;?> </td>
							<td><?php echo $row['dated'];?> </td>	
                            <td><?php echo $row['time'];?> </td>	
                            <td><?php echo $row['fname'] .' '.$row['lname'];?> </td>	

                            <td><?php echo $row['email'];?> </td>	
                            <td><?php echo $row['phone'];?> </td>	
                            <td nowrap="nowrap"><?php echo $row['name'];?> </td>	
                            <td><?php echo $row['qty'];?> </td> 
                            <td><?php echo $row['cc_0'];?> </td>
                            <td><?php echo $row['cc_1'];?> </td>
                            <td><?php echo $row['cc_2'];?> </td>
                            <td><?php echo $row['cc_3'];?> </td>
                            <td><?php echo $row['cc_4'];?> </td>
                            <td><?php echo $row['cc_5'];?> </td>

                            <td><?php echo $row['initialCharacters'];?> </td>
                            <td><?php echo $row['address'];?></td>
                            
                            <td><?php echo $row['country'];?></td>
                              
                              <?php if($row['country'] == 'Kuwait'){
						      ?>
                               
                            <td> <?php echo (($row['qty']*$row['price']) + 3)."KD";?> </td>
                              <?php }else{ ?>
                             
                             <td> <?php echo $row['qty']*$row['price']."KD";?> </td>
							    <?php } ?>
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
                            <td><?php echo $row['name'];?> </td>	
                            <td><?php echo $row['qty'];?> </td>
                            <td><?php echo $row['cc_0'];?> </td>
                            <td><?php echo $row['cc_1'];?> </td>
                            <td><?php echo $row['cc_2'];?> </td>
                            <td><?php echo $row['cc_3'];?> </td>
                            <td><?php echo $row['cc_4'];?> </td>
                            <td><?php echo $row['cc_5'];?> </td>
                            

                            <td><?php echo $row['initialCharacters'];?> </td>
                            <td>  </td>
                            <td>  </td>
                            
                           <?php if($row['country'] == 'Kuwait'){
						      ?>
                               
                            <td> <?php echo (($row['qty']*$row['price']) + 3)."KD";?> </td>
                              <?php }else{ ?>
                             
                             <td> <?php echo $row['qty']*$row['price']."KD";?> </td>
							    <?php } ?>

                            
							
							  			  </tr>
                                          <?php 
			
		
		}
		$orderflag = $row['OrderNo'];
		$srNo++;
	}
	
					
					?>	
				  <tr>
					<td   colspan="18" ><?php include('common/paginglayout.php');?></td>
				  </tr>	     			
			</table>				
	</div>
</div>