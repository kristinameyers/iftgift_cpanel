<?php
include ("../../connect/connect.php");


 
 
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
	 $sql = "select order_no as OrderNo, orders.dated, orders.time, orders.fname, orders.time, orders.lname, orders.email, orders.phone, orders.address, orders.country, order_detail.qty, order_detail.price, order_detail.initialCharacters, product.name , order_detail.pattrenId 
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

	$qryString =" where 1  ";

	



	  


  $sortyby = '  order by  report.dated desc ';
	 $sql = "select *  FROM report $qryString $sortyby ";
 
  $result = @mysql_query($sql) or die (mysql_error());

  
  $csvData[0] = array ( "#","Order Number","Date","Time","Customer Name","Customer Email","Contact Number","Item","Qty", 'Ptn-1' ,'Ptn-2' ,'Ptn-3' ,'Ptn-4' ,'Ptn-5' ,'Ptn-6'  ,"Initials", "Delivery Address","Delivery/Country","Total Price" );
  $srNo =1;
 

	$orderflag	 = '';			
  while( $row = @mysql_fetch_array($result) )
  {
	  
		
		if ( $orderflag != $row['order_no'] )
		{
		
		$csvData[$srNo] = array ( $srNo ,  $row['order_no']  , $row['dated'] , $row['time'], $row['fname']." ".$row['lname'],		$row['cus_email'] ,'="'. $row['con_no'].'"' , $row['item'],$row['qty'],$row['ptn_1'], $row['ptn_2'], $row['ptn_3'], $row['ptn_4'], $row['ptn_5'],  $row['ptn_6'] ,$row['initials'] , $row['address']  , $row['country'] , $row['total_price']."KD" );
		
		}else{

	$csvData[$srNo] = array (  $srNo , ' ' , ' ' , ' ', ' ',	' ' ,' ', $row['item'],$row['qty'],$row['ptn_1'], $row['ptn_2'], $row['ptn_3'], $row['ptn_4'], $row['ptn_5'],$row['ptn_6'],$row['initials'], ' ', ' ',$row['total_price']."KD" );
		
		}
		$orderflag = $row['order_no'];
		$srNo++;
	}
 
$delimiter = "\t";

$filename="report". strtotime('now').".xls";



//  print_r( $rec); exit;
	  

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

	if(count($csvData)>0)
	{
		foreach($csvData as $items)
		{	
		
			 $dataRowString = implode($delimiter, $items);
    		print $dataRowString . "\r\n";
		}
	}
	

?>