<?php 

require_once("../../connect/connect.php");
include ('../security.php');
include ("../common/function.php");

//include ('../security.php');
$return_ref_no= $_GET['ref'];

 // The URL to POST to
  $url = "http://live.gotapnow.com/webservice/PayGatewayService.svc";
 
  // The value for the SOAPAction: header
  $action = "http://tempuri.org/IPayGatewayService/GetOrderStatusRequest";
  
 
  // Get the SOAP data into a string, I am using HEREDOC syntax
  // but how you do this is irrelevant, the point is just get the
  // body of the request into a string
  

//select tap refernce number///
$qry_ref=mysql_query("select tap_ref_no from orders where order_no != '0' and tap_ref_verified = false") or die (mysql_error());

while($qry_ref_items=mysql_fetch_array($qry_ref))
{


$client = new nusoap_client("http://live.gotapnow.com/webservice/PayGatewayService.svc?wsdl",true);
 
$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}
$client->soap_defencoding = 'UTF-8';
 
$result = $client->call("GetOrderStatusRequest",array("MerchantID" => "3042", "ReferenceID" => "$qry_ref_items[tap_ref_no]", "Password" => "4l3S3T5gQvo%3d", "UserName" => "tap@piecesbyfarah"));
 
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error new</h2><pre>" . $error . "</pre>";
    }
    else {
        
		
		if ($result['ResponseCode'] == '0')
		{
		$query=mysql_query("update orders set tap_ref_verified = true where tap_ref_no = '$qry_ref_items[tap_ref_no]' ") or die ("error: ".mysql_error());
		
		}
		//update order with verified ///
		$query_ins=mysql_query("insert into payment_log set 
										tap_ref_no		= '$qry_ref_items[tap_ref_no]',
										transaction_id	= '1',
										payment_mode	= 'Visa',
										response_code	= '1001',
										response_msg	= 'testing message' ") or die(mysql_error());
										
										/*tap_ref_no		= '$qry_ref_items[tap_ref_no]',
										transaction_id	= '$result[PayTxnID]',
										payment_mode	= '$result[Paymode]',
										response_code	= '$result[ResponseCode]',
										response_msg	= '$result[ResponseMessage]'*/
		
    }
}
	
	
}
exit;


?>