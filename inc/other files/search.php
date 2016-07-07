<?php

include ("../../connect/connect.php");


// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;

$q = strtolower($_GET["term"]);
$f = $_GET["f"];
// remove slashes if they were magically added
if (get_magic_quotes_gpc()) $q = stripslashes($q);

$qryString = ' where '. $f .' like "'. $q.'%" ';

  $sortyby = '  order by  report.order_no desc ';
 $sql = "select distinct $f as fdata  FROM report $qryString $sortyby  limit 0,10";
	   $result = @mysql_query($sql) or die (mysql_error());
$items = array();

while( $row = @mysql_fetch_array($result) )
  {

	  array_push($items, array( "value" => strip_tags($row['fdata'])));

	  if (count($items) > 11)		break;
  }

// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
echo json_encode($items);

?>