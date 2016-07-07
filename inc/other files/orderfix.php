<?php
include ("../../connect/connect.php");


 

	$sql = "select orders.Id FROM `orders` JOIN order_detail ON order_detail.oId = orders.id JOIN product ON product.Id=order_detail.pId where fname != ''  group by   orders.Id
order by  orders.dated asc"; 

 
 $result = @mysql_query($sql);
 
 $orderNumber =1;
 
 while( $row = @mysql_fetch_array($result) )
  {
	
	mysql_query(" update  orders set order_no=	  $orderNumber  where  Id = ". $row['Id'] );
	
	$orderNumber ++;
		
	}

?>