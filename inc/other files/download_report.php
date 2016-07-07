<?php
include ("../../connect/connect.php");


 

	$qryString =" where 1  ";

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
	  
/* */

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