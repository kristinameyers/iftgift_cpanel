<?php 
if ( isset($_GET['Id']) and $_GET['Id'] != '')
{ 

	mysql_query("update orders set status = '1' where Id = '".$_GET['Id'] ."'");
	
	$Order_sql  = mysql_query("select * from orders where Id = '".$_GET['Id'] ."'");
	$rowOrder   = mysql_fetch_array($Order_sql);
	
	$cartQry =  mysql_query(" select * from order_detail where oId = '".$_GET['Id']."' order by Id " );
	if (mysql_num_rows($cartQry) == 0 ) 
	{
		//header('lcation:'. ru ); exit;
	}
	
	$cartItem = 0;
	while ($rowCart = mysql_fetch_array($cartQry) ) 
	{
		$cartData[] = $rowCart;
		$cartItem +=  $rowCart['qty'];
		
	}
	
}
?>

<div class="content-box">
	<div class="content-box-header">

		<h3>Customer Order Detail</h3>

		<div class="clear"></div>
	</div>
	<div class="content-box-content">                    

   <div id="main">
						<form action="#" method="post">
                    	<fieldset><legend><h4>Customer Information</h4></legend>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Customer Name:</label>&nbsp;&nbsp;<?php echo $rowOrder['fname']." ".$rowOrder['lname']; ?></p>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Email Address:</label>&nbsp;&nbsp;<?php echo $rowOrder['email']; ?></p>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Phone Number:</label>&nbsp;&nbsp;<?php echo $rowOrder['phone']; ?></p>
						 <p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Address:</label>&nbsp;&nbsp;<?php echo stripslashes($rowOrder['address']); ?></p>
						 <label>
						 <h4 style="background-color:#f1f1f1; padding:10px 0px 10px 10px;">Payment Log</h4>
						 </label>
                         
                         <div class="cart-detail-outer" style="width:71%; margin-left:1%; margin-top:5px; height:auto;"></div>
                         
          <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
          <tr>
          
          <td width="20%"><strong>Tap Reference Number</strong></td>
          <td width="20%"><strong>Transaction ID</strong></td>
          <td width="20%"><strong>Payment Mode</strong></td>
          <td width="20%"><strong>Response Code</strong></td>																		
          <td width="20%"><strong>Response message</strong></td>
          </tr>	
          
						 <?php
						 
						 $pay_log=mysql_query("select * from payment_log 
						 		where tap_ref_no = '$rowOrder[tap_ref_no]'");
						while($pay_log_items=mysql_fetch_array($pay_log)){
							echo "<tr>";
							echo "<td width='20%'>". $pay_log_items['tap_ref_no']."</td>";
							echo "<td width='20%'>".$pay_log_items['transaction_id']."</td>";
							echo "<td width='20%'>".$pay_log_items['payment_mode']."</td>";
							echo "<td width='20%'>".$pay_log_items['response_code']."</td>";
							echo "<td width='20%'>".$pay_log_items['response_msg']."</td>"; 
							echo "</tr>";
							}
						  ?>
                         
				
                </table>                         
                         
                         <label>
						 <h4 style="background-color:#f1f1f1; padding:10px 0px 10px 10px;">Customer Order Information</h4>
						 </label>
						 
						 <div class="cart-detail-outer" style="width:71%; margin-left:1%; margin-top:5px; height:auto;">
				 <?php 
		
				foreach ( $cartData as $cartItem){
				$proId = $cartItem['pId'];

				$sqlProduct = 	  @mysql_query("SELECT name, logo, logo1 from product where Id = '$proId'");
				$rowProduct = @mysql_fetch_array($sqlProduct);
				
				$imagePath = 'media/logo/'.$rowProduct['logo'];
									
				if($arrResults['logo1']!=''){
				
				$imagePath = 'media/logo/'.$rowProduct['logo1'];
				
				} else {
				
				$imagePath = 'media/logo/'.$rowProduct['logo'];
				
				}
				
				 ?>
<div class="cart_main_detail" <?php if ($firt_item) { echo ' style="border:none;" '; $firt_item=false; } ?> >
                                   <div class="floating-txt"> <?php echo $rowProduct['name'];?> <br>
                                        <span>+ customized choices</span> </div>
                                   
						<div style="float:right; width:88px;">
						<img src="<?php echo $imagePath;?>" width="80" />
						</div>
                              <?php 
		
	
		
		$colorId 		 =  explode( ',',  $cartItem['colorId']);
		$colorpalletId   =  explode( ',',$cartItem['colorpalletId']);
		
		$pattrenId 		 =  explode( ',',  $cartItem['pattrenId']);
		$pattrenpalledId =  explode( ',',  $cartItem['pattrenpalledId']);
    		
		?>
                              <div class="cart-detail" style="margin-bottom:15px;">
                                   <?php
					
					if(  $colorpalletId[0] != '') 
					{
						foreach ( $colorpalletId as $cpk=>$cpv) 
						{
						
						$sqlcolorPallet = @mysql_query("SELECT p.Id, p.name from pallet as p where  p.Id  =". $colorpalletId[$cpk] );
						$rowColorPallet = @mysql_fetch_array($sqlcolorPallet);
						
						$sqlcolor = @mysql_query("SELECT c.code_name, c.name as cName from  color as c where c.Id  =". $colorId[$cpk] );
						$rowColor = @mysql_fetch_array($sqlcolor);
						
						?>
						
                                   <div class="detail-outer">
								   
                                        <div class="vaneer">
                                             <h2><?php echo $rowColorPallet['name']?></h2>
                                        </div>
                                        <div class="ref">
										<div style="width:50px; float:left;">ref.</div><div style="width:60px; float:left;"><?php echo $rowColor['code_name']?></div><?php echo $rowColor['cName']?> </div>
                                   </div>
                                   <div style="clear:both;"></div>
                                   <?php 
						}
					}
					
					if(  $pattrenpalledId[0] != '')
					{
						foreach ( $pattrenpalledId as $Ppk=>$Ppv) 
						{
							
						$sqlpatPallet = @mysql_query("SELECT p.Id, p.name from pattren_pallet as p where   p.Id  =". $pattrenpalledId[$Ppk] );
						$rowpatPallet = @mysql_fetch_array($sqlpatPallet);
						
						$sqlpat = @mysql_query("SELECT  pt.pcode_name, pt.name as cName from pattren as pt where pt.Id  =". $pattrenId[$Ppk] );
						$rowPat = @mysql_fetch_array($sqlpat);
						
						?>
                                   <div class="detail-outer">
                                        <div class="vaneer">
                                             <h2><?php echo $rowpatPallet['name']?></h2>
                                        </div>
                                        <div class="ref">
										<div style="width:50px; float:left;">ref.</div><div style="width:60px; float:left;"><?php echo $rowPat['pcode_name']?></div><?php echo $rowPat['cName']?> </div>
                                   </div>
                                   <div style="clear:both;"></div>
                                   <?php } 
					} ?>
									<div class="detail-outer" style="margin-top:15px;">
                                        <div class="vaneer">
                                             <h2 style="float:left;">Unit Price</h2>
                                        </div>
                                        <div class="ref">
                                             <h2>
                                            <?php echo $cartItem['price']?> KD
                                              </h2>
                                        </div>
                                   </div>
                                   <div class="detail-outer" style="margin-top:15px;">
                                        <div class="vaneer">
                                             <h2 style="float:left;">Qty</h2>
                                        </div>
                                        <div class="ref">
                                             <h2>
                                            <?php if($cartItem['qty']<10) echo '0';?><?php echo $cartItem['qty'] ?> Piece<?php if($cartItem['qty']>1) echo 's'; ?>
                                              </h2>
                                        </div>
                                   </div>
                                   <div class="detail-outer">
                                        <div class="vaneer">
                                             <h2 style="float:left;">Total Price</h2>
                                        </div>
                                        <div class="ref">
                                             <h2><?php echo $cartItem['price']*$cartItem['qty']?> KD</h2>
                                        </div>
                                   </div>
                              </div>
                              <?php } ?>
                              <div class="detail-outer">
                                   <div class="vaneer">
                                        <h2 style="float:left;">Shipping / Delivery</h2>
                                   </div>
                                   <div class="ref">
                                        <h2>
									        <?php echo $rowOrder['country'];?>
                                        </h2>
                                   </div>
                                  
                                                                   
                              <div class="cart_main_detail">
                                   <div class="floating-txt" style="font-size:12px;"><strong>TOTAL SHOPPING</strong><br /><br/> </div>
                              </div>
                               <div class="vaneer">
                                         
											     
                                        <h2 style="float:left;">DELIVERY CHARGES</h2>
                                   </div>
                                   <div class="ref">
                                        <h2>
										 <?php if($rowOrder['country'] == 'Kuwait') { 
										        echo "03KD";
										    }else{
												
												echo "---";
												}
										 ?>
									           
									    </h2>
                                   </div>
                                 </div>
                              <div class="detail-outer">
                                   <div class="vaneer">
                                        <h2 style="float:left;">TOTAL QTY</h2>
                                   </div>
                                   <div class="ref">
                                        <h2>
									<?php
									foreach ( $cartData as $cartItems){
									$totalQty+= $cartItems['qty'];
									$totalPrice+= $cartItems['price']*$cartItems['qty'];
									}
									if($totalQty<10) echo '0';?><?php echo $totalQty?> Piece<?php if($totalQty>1) echo 's'; 
									?>
                                        </h2>
                                   </div>
                              </div>
							  
                              <div class="detail-outer">
                                   <div class="vaneer">
                                        <h2 style="float:left;">TOTAL PRICE</h2>
                                   </div>
                                   <div class="ref">
                                         <?php 
										  if($rowOrder['country'] == 'Kuwait')
										  {
											   ?>
											<h2><?php echo $totalPrice + 3;?> KD</h2>  
										   	  
											 <?php }else{ ?>
										 
										  
                                        <h2><?php echo $totalPrice?> KD</h2>
                                         <?php } ?> 
                                   </div>
                              </div>
							
			<div class="cb"></div>
			
		</div>
						 
						 </fieldset>
						</form>
					
                </div>
            </div>
        </div>	     
