<?php
$adjacents = 2;

if ( !isset ( $limit )) $limit =  20;

$ppage = 'page';

$targetpage = $_SERVER['REQUEST_URI'];
list($targetpage) = explode("&".$ppage."=",$targetpage);

$pagingpage = $_GET[$ppage];
if($pagingpage)
{
	$start = ($pagingpage - 1) * $limit; 			//first item to display on this page
}
else
{
	$start = 0;								//if no page var is given, set start to 0
}

if ($pagingpage == 0) $pagingpage = 1;
$prev = $pagingpage - 1;
$next = $pagingpage + 1;
$lastpage = ceil($total_pages/$limit);
$lpm1 = $lastpage - 1;
?>