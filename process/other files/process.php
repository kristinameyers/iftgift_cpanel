<?php
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');

foreach($_POST  as $key => $value)
	{
	   $$key = $value;
	}
	foreach($_GET as $key => $value)
	{
	   $$key = $value;
	}
	
	unset($_SESSION['sesErr']);
	unset($_SESSION['regUser']);
	$p = $_GET['p'];
	
	
	
	/////////////////////////process City /////////////////////////////////////////////////////
if($p=='addnewCity')
{
	
	$state=trim(addslashes($_POST['state']));
	$City=trim(addslashes($_POST['City']));
	$county=trim(addslashes($_POST['county']));
	if($City=='')
	{
	  $flag=true;
	  $_SESSION['Cityerror']='Please enter  City';
	}

	if($flag)
	{
	  header("location:".ruadmin."home.php?p=managecities");
	  exit;
	}

	$sql = "INSERT INTO norio_citystate set state='".$state."', city='".$City."', county = '".$county."'";

	mysql_query($sql);
	$_SESSION['statuss']='City added successfully';
	header("location:".ruadmin."home.php?p=managecities");
	exit;
	
}

if($p=='editnewCity')
{
	
	$cid=$_GET['cid'];

	$state=trim(addslashes($_POST['state']));
	$City=trim(addslashes($_POST['City']));
	$county=trim(addslashes($_POST['county']));
	if($City=='')
	{
	  $flag=true;
	  $_SESSION['Cityerror']='please enter  City';
	}
	if($flag)
	{
	  header("location:".ruadmin."home.php?p=managecities");
	  exit;
	}
	
	$sql = "update norio_citystate set state='".$state."' , city='".$City."', county = '".$county."' where cityid =$cid";
	//echo $sql;exit;
	mysql_query($sql);
	$_SESSION['statuss']=$City.' - updated successfully';
	header("location:".ruadmin."home.php?p=managecities");
	exit;
	
}


if($p=='delnewCity')
{


	$cid=$_GET['cid'];
	$sql = "DELETE FROM norio_citystate where cityid=".$cid;
	

	if(mysql_query($sql))
	{
		$_SESSION['statuss']='State Deleted successfully';
		header("location:".ruadmin."home.php?p=managecities");
		exit;
	}
	exit;
}



	
	/////////////////////////process County /////////////////////////////////////////////////////
if($p=='addnewcounty')
{
	
	$state=trim(addslashes($_POST['state']));
	$county=trim(addslashes($_POST['county']));
	if($county=='')
	{
	  $flag=true;
	  $_SESSION['countyrror']='Please enter  county';
	}

	if($flag)
	{
	  header("location:".ruadmin."home.php?p=managecounties");
	  exit;
	}

	$sql = "INSERT INTO norio_countystate set state='".$state."', county='".$county."'";

	mysql_query($sql);
	$_SESSION['statuss']='County added successfully';
	header("location:".ruadmin."home.php?p=managecounties");
	exit;
	
}

if($p=='editnewcounty')
{
	
	$cid=$_GET['cid'];

	$state=trim(addslashes($_POST['state']));
	$county=trim(addslashes($_POST['county']));
	if($county=='')
	{
	  $flag=true;
	  $_SESSION['countyrror']='please enter  county';
	}
	if($flag)
	{
	  header("location:".ruadmin."home.php?p=managecounties");
	  exit;
	}
	
	$sql = "update norio_countystate set state='".$state."' , county='".$county."' where  countyid =$cid";
	//echo $sql;exit;
	mysql_query($sql);
	$_SESSION['statuss']=$county.' - updated successfully';
	header("location:".ruadmin."home.php?p=managecounties");
	exit;
	
}


if($p=='delnewcounty')
{


	$cid=$_GET['cid'];
	$sql = "DELETE FROM norio_countystate where countyId = ".$cid;
	

	if(mysql_query($sql))
	{
		$_SESSION['statuss']='County Deleted successfully';
		header("location:".ruadmin."home.php?p=managecounties");
		exit;
	}
	exit;
}


/////////////////////////process review /////////////////////////////////////////////////////
if($p=='editreview')
{
	
	$rid=$_GET['rid'];
	$bid=$_POST['bid'];
	$status=$_POST['status'];
	$rating=trim(addslashes($_POST['rating']));
	$ryes=trim(addslashes($_POST['ryes']));
	$rno=trim(addslashes($_POST['rno']));	
	$review=trim(addslashes($_POST['review']));		

	$sql = "update business_reviews set review='".$review."' ,status=".$status.", rating='".$rating."', review_yes='".$ryes."', review_no='".$rno."' where  r_id =".$rid." ";

	mysql_query($sql);
	$_SESSION['statuss']=" Review updated successfully";
	header("location:".ruadmin."home.php?p=businessreviews&bId=".$bid."&page=".$_GET['page']);
	exit;
	
}

if($p=='delusrbookmark')
{
	$bid=$_GET['bid'];
	$uid=$_GET['uid'];
	$sql = "DELETE FROM userbookmark where userId=".$uid." and locationid =".$bid;
	

	if(mysql_query($sql))
	{
		$sql2 = "update business set bookmark_count = (bookmark_count-1) where locationid =".$bid."";
		mysql_query($sql2);
		
		$_SESSION['statuss']='Bookmark deleted successfully';
		header("location:".ruadmin."home.php?p=userbusinessbookmark&uid=".$uid."&page=".$_GET['page']);
		exit;
	}
	exit;
}

if($p=='delbookmark')
{
	$bid=$_GET['bid'];
	$uid=$_GET['uid'];
	$sql = "DELETE FROM userbookmark where userId=".$uid." and locationid =".$bid;
	

	if(mysql_query($sql))
	{
		$sql2 = "update business set bookmark_count = (bookmark_count-1) where locationid =".$bid."";
		mysql_query($sql2);
		
		$_SESSION['statuss']='Bookmark deleted successfully';
		header("location:".ruadmin."home.php?p=businessbookmark&bId=".$bid."&page=".$_GET['page']);
		exit;
	}
	exit;
}

if($p=='delviewip')
{
	$bid=$_GET['bid'];
	$ip=$_GET['ip'];
	$sql = "DELETE FROM business_view  where fromip='".$ip."' and locationid =".$bid;
	

	if(mysql_query($sql))
	{
		$sql2 = "update business set view_count = (view_count-1) where locationid =".$bid."";
		mysql_query($sql2);
		
		$_SESSION['statuss']='Bookmark deleted successfully';
		header("location:".ruadmin."home.php?p=businessviews&bId=".$bid."&page=".$_GET['page']);
		exit;
	}
	exit;
}

if($p=='delreview')
{
	$bid=$_GET['bid'];
	$rid=$_GET['rid'];
	$sql = "DELETE FROM business_reviews where r_id='".$rid."'";

	if(mysql_query($sql))
	{
		
		$sql33 = "DELETE FROM business_reviews where parent_r_id = '".$rid."'";
		mysql_query($sql33);
		
		$review_count_res = mysql_query("select count(r_id) as totr from business_reviews where locationid = '".$bid."' and (parent_r_id = 0 or parent_r_id = '')");
		$review_count = mysql_fetch_array($review_count_res);
		
		$avg_rat_res = mysql_query("select AVG(rating) avgrat from business_reviews where locationid = '".$bid."' and (parent_r_id = 0 or parent_r_id = '')");
		$avg_rat = mysql_fetch_array($avg_rat_res);
		
		mysql_query("update business set review_count = '".$review_count['totr']."', avgrating = '".$avg_rat['avgrat']."' where locationid = '".$bid."'");
		/*$sql2 = "update business set review_count = (review_count-1) where locationid =".$bid."";
		mysql_query($sql2);
		*/
		$_SESSION['statuss']='Review deleted successfully';
		header("location:".ruadmin."home.php?p=businessreviews&bId=".$bid."&page=".$_GET['page']);
		exit;
	}
	exit;
}

if($p=='blockip')
{
	$bid=$_GET['bid'];
	$ip=$_GET['ip'];
    $qrysrc = "select count(ip) from bannedip where ip='".$ip."'";
	$qryKcounts = mysql_query($qrysrc);
	$rowKcounts = mysql_fetch_array($qryKcounts);
	
   if($rowKcounts[0] == 0)
   {
		$sql = "INSERT INTO bannedip set ip='".$ip."'";
		mysql_query($sql);
		
		$_SESSION['statuss']='This IP successfully added in banned list';
		header("location:".ruadmin."home.php?p=businessviews&bId=".$bid."&page=".$_GET['page']);
		exit;
	}
	$_SESSION['statuss']='This IP already added in banned list';
	header("location:".ruadmin."home.php?p=businessviews&bId=".$bid."&page=".$_GET['page']);	
	exit;
}
if($p=='bannedip')
{

   $txtip=addslashes($_POST['txtip']);
   $qrysrc = "select count(ip) from  bannedip where ip='".$txtip."'";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['titleerror']='This IP already added in banned list';
	  header("location:".ruadmin."home.php?p=bannedip");
	  exit;

	}
   $flag=false;
   if(!$txtip)
   {
	  $flag=true;
	  $_SESSION['statuss']='Please Enter valid IP address';
	  header("location:".ruadmin."home.php?p=bannedip");
	  exit;
   }

   if(!$flg)
	{
		$sql = "INSERT INTO bannedip set ip='".$txtip."'";
		mysql_query($sql);
		$catId = mysql_insert_id();
		
		$_SESSION['statuss']='This IP successfully added in banned list';
		header("location:".ruadmin."home.php?p=bannedip");
		exit;
	}
//
}
if($p=='delbannedip')
{

	$ip=$_GET['ip'];
	$sql = "DELETE FROM bannedip where ip='".$ip."'";
	mysql_query($sql);
	$_SESSION['statuss']='Banned IP successfully removed from banned list';
	header("location:".ruadmin."home.php?p=bannedip&page=".$_GET['page']);
	exit;
}

////////////////////////////////////mapkeyword  /////////////////////////////////

////////////////////////////////////mapkeyword  /////////////////////////////////
if($p=='mapkeyword')
{
	if ( isset($_POST['Save']) and ( $_POST['MainCategory'] != '') )
	{
		$list1 = trim( $_POST['list_1_serialised']);
		$list2 = trim( $_POST['list_2_serialised']);
		$catId = $_POST['MainCategory'];
		updatekeyword  ($list1 , '0');
		updatekeyword  ($list2 , $catId);
		header('location:'.ruadmin.'home.php?p=keyword&i='.$catId);
		exit;
	}else{
		header('location:'.ruadmin.'home.php?p=keyword');
		exit;
	}
		
}
function updatekeyword ($list ,  $cId =0)
		{
			if (!$list==''){
				$kwArray = str_replace('list_1_item_','' ,$list);
				mysql_query("update keyword set cid = '".$cId."' where id in (".$kwArray.")");
			}
		}
///// Search Enhance starts /////////

if($p=='addSearchkeyword')
{
   $title=addslashes(trim($_POST['txttitle']));
   

    $qrysrc = "select count(id) from enhance_search where word='".$title."'";
	$qryKcounts = mysql_query($qrysrc);
	$rowKcounts = mysql_fetch_array($qryKcounts);
	
   $flag=false;
   if($rowKcounts[0]> 0)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Search keyword already exits.';
	  header("location:".ruadmin."home.php?p=search_enhance");
	  exit;
   }

   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Search Keyword';
	  header("location:".ruadmin."home.php?p=search_enhance");
	  exit;
   }

	if(!$flg)
	{
		$mode = $_POST['cat']; 
		$sql = "INSERT INTO enhance_search set word='".$title."' , mode = '".$mode."' ";
		$ss = mysql_query($sql);
	
		$_SESSION['statuss']='Search Keyword added successfully';
		header("location:".ruadmin."home.php?p=search_enhance");
		exit;
	}
//
}



if($p=='editSearchWord')
{
   $title=addslashes(trim($_POST['txttitle']));
   

   $flag=false;
   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Search Keyword';
	  header("location:".ruadmin."home.php?p=search_enhance");
	  exit;
   }
	$id =$_GET['id'];
	if(!$flg)
	{
		$mode = $_POST['cat']; 
		$sql = "Update enhance_search set word='".$title."' , mode = '". $mode ."' where id =$id";
		$ss = mysql_query($sql);
	
		$_SESSION['statuss']='Search Keyword Updated successfully';
		header("location:".ruadmin."home.php?p=search_enhance");
		exit;
	}
}

if($p=='delSearchWord')
{
  $id =$_GET['id'];
  		
		$sql = "delete from enhance_search where id =$id";
		$ss = mysql_query($sql) or die(mysql_error());
	
		$_SESSION['statuss']='Search Keyword Deleted';
		header("location:".ruadmin."home.php?p=search_enhance");
		exit;
}






/////////Search Enhance Ends/////////

////////////////////////////////add new keyword /////////////////////////////////////////

if($p=='addkeyword')
{
   $title=addslashes(trim($_POST['txttitle']));
   
    $qrysrc = "select count(catid) from category where cat_name='".$title."'";
	$qryKcounts = mysql_query($qrysrc);
	$rowKcounts = mysql_fetch_array($qryKcounts);
	
   $flag=false;
   if($rowKcounts[0]> 0)
   {
	  $flag=true;
	  $_SESSION['titleerror']='keyword already exits.';
	  header("location:".ruadmin."home.php?p=keywords");
	  exit;
   }

   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter keyword';
	  header("location:".ruadmin."home.php?p=keywords");
	  exit;
   }

	if(!$flg)
	{
		$cid = $_POST['cat']; 
		list($catid,$catname) = split(":",$cid);
		$sql = "INSERT INTO category set cat_name='".$title."' , p_catid = '".$catid."' ";
		$ss = mysql_query($sql);
		$keywordId = mysql_insert_id();

		$sql = "Update business set keywords=concat(keywords,',".$title."') where industry ='".$catname."'";
		$ss = mysql_query($sql);

		$_SESSION['statuss']='Keyword added successfully';
		header("location:".ruadmin."home.php?p=keywords&cid=".$catid);
		exit;
	}
//
}



////////////////////////////////add new city /////////////////////////////////////////

if($p=='addkcity')
{
   $city=addslashes($_POST['city']);
   $state=addslashes($_POST['state']);
   

	if($city=='-1' or $state=='-1' )
	{
	  $flag=true;
	  $_SESSION['statuss']='please select City & State';
	  header("location:".ruadmin."home.php?p=managecity");
	  exit;

	}
	$qrysrc = "select count(id) from  tblcitykeyword where  city='".$city."' AND state='".$state."'";
    $qryCScounts = mysql_query($qrysrc);
    $rowCScounts = mysql_fetch_array($qryCScounts);
    if($rowCScounts[0]> 0){
		$flag=true;
	  	$_SESSION['statuss']='Already this City & State combination added';
	    header("location:".ruadmin."home.php?p=managecity");
	    exit;
	}
	
	$sql = "INSERT INTO tblcitykeyword set city='".$city."' , state='".$state."' ";

	mysql_query($sql);
	$_SESSION['statuss']='City name added successfully';
	header("location:".ruadmin."home.php?p=managecity");
	exit;
	
//
}
//////////////////// edit City sear /////////////////////////////////////

if($p=='editcitysearch')
{
	$sql = "UPDATE tblcitykeyword SET cityname='".$_POST['cityname']."' where id='".$_GET['cid']."' ";
	mysql_query($sql);
	

	
	$_SESSION['statuss']='City name updated successfully';
	header("location:".ruadmin."home.php?p=managecity&page=".$_GET['page']);
	exit;
}
//////////////////// edit keyword /////////////////////////////////////
if($p=='editkeyword')
{

	$oldkw = $_POST['oldkw'];
	$newkw = $_POST['title'];
	if ( trim ($newkw) == ''){
	
		$_SESSION['statuss']='Keyword Empty/Ivalid';
		header("location:".ruadmin."home.php?p=keywords&page=".$_GET['page']);
		exit;
	}

/*	$SearchQuery = mysql_query( "SELECT  locationid, keywords FROM  business  where
					( 	keywords like  '".$oldkw."' or 
						keywords like  '%,".$oldkw.",%' or 
						keywords like  '".$oldkw.",%'  or 
						keywords like  '%,".$oldkw."'  ) ");
	while ( $bizRow = mysql_fetch_array($SearchQuery ) )
	{
		$newkwd = str_replace(",".$oldkw."," ,",".$newkw."," ,$bizRow['keywords'] );
		$newkwd = str_replace(",".$oldkw ,",".$newkw  ,$bizRow['keywords'] );
		$newkwd = str_replace($oldkw."," ,$newkw.","  ,$bizRow['keywords'] );
		$newkwd = str_replace($oldkw ,$newkw ,$bizRow['keywords'] );
		mysql_query("update business set keywords = '$newkwd' where  locationid = ".$bizRow['locationid']);
	}	
*/
	$updatery = "UPDATE business SET keywords =  REPLACE( keywords, '".$oldkw."', '".$newkw."' ) WHERE keywords like  '".$oldkw."' or keywords like  '%,".$oldkw.",%' or keywords like  '".$oldkw.",%'  or keywords like  '%,".$oldkw."' ";
	mysql_query($updatery);
	
	$sql = "UPDATE category SET cat_name='".$newkw."' , p_catid = ".$_POST['cat']." where catid='".$_GET['cid']."' ";
	mysql_query($sql);
	
	$_SESSION['statuss']='Keyword Updated successfully';
	header("location:".ruadmin."home.php?p=keywords&page=".$_GET['page']."&cid=".$_POST['cat']);
	exit;
}

/////////////////////////////// delete keyword //////////////////////////////
if($p=='delkw')
{
	$cid=$_GET['cid'];
	$kw=$_GET['kw'];	
	
	$sql = "DELETE FROM category where catid='".$cid."'"; 

	$SearchQuery = mysql_query( "SELECT  locationid, keywords FROM  business  where
					( 	keywords like  '".$kw."' or 
						keywords like  '%,".$kw.",%' or 
						keywords like  '".$kw.",%'  or 
						keywords like  '%,".$kw."'  ) ");
	while ( $bizRow = mysql_fetch_array($SearchQuery ) )
	{
		
		$newkey = str_replace(",".$kw."," ,"," ,$bizRow['keywords'] );
		$newkey = str_replace(",".$kw ,"" ,$bizRow['keywords'] );
		$newkey = str_replace($kw."," ,"" ,$bizRow['keywords'] );
		$newkey = str_replace($kw ,"" ,$bizRow['keywords'] );
		
		mysql_query("update business set keywords = '$newkey' where  locationid = ".$bizRow['locationid']);
	}
	
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Keyword  Deleted successfully';
		header("location:".ruadmin."home.php?p=keywords&page=".$_GET['page']);
		exit;
	}
	exit;
}
/////////////////////////////// delete city //////////////////////////////
if($p=='delcty')
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM tblcitykeyword where id='".$cid."'"; 

	if(mysql_query($sql))
	{
		$_SESSION['statuss']='City name  deleted successfully';
		header("location:".ruadmin."home.php?p=managecity&page=".$_GET['page']);
		exit;
	}
	exit;
}
/////////////////////////////// Add manual Payment //////////////////////////////
if($p=='payment')
{
	$bussId=$_POST['bussId'];
	$userId=$_POST['userId'];
	$affiliateID=$_POST['affiliateID'];	
	$package=$_POST['package'];
	if($package == '1'){
		$expiry = (time() + 86400 * 30 * 3);
		$busstype = 1;
		$bussLimit = 5;
		$amount=$e3;
	}
	elseif($package == '2'){
		$expiry = (time() + 86400 * 30 * 6);
		$busstype = 1;
		$bussLimit = 5;	
		$pid=$e6;
	}
	elseif($package == '3'){
		$expiry = (time() + 86400 * 30 * 9);
		$busstype = 1;
		$bussLimit = 5;	
		$amount=$e9;
	}
	elseif($package == '4'){
		$expiry = (time() + 86400 * 365);
		$busstype = 1;
		$bussLimit = 5;	
		$amount=$e12;		
	}
	elseif($package == '5'){
		$expiry = (time() + 86400 * 30 * 3);
		$busstype = 2;
		$bussLimit = 8;	
		$amount=$d3;
	}
	elseif($package == '6'){
		$expiry = (time() + 86400 * 30 * 6);
		$busstype = 2;
		$bussLimit = 8;	
		$amount=$d6;
	}
	elseif($package == '7'){
		$expiry = (time() + 86400 * 30 * 9);
		$busstype = 2;
		$bussLimit = 8;
		$amount=$d9;	
	}
	elseif($package == '8'){
		$expiry = (time() + 86400 * 365);
		$busstype = 2;
		$bussLimit = 8;	
		$amount = $d12;
	}
					

	$tId = time();
	if(trim($amount)==''){
		$amount = 0;
	}
	/*$qry_config="SELECT e3 ,e6 ,e9 ,e12 , d3 , d6 ,d9 , d12  FROM tbladmin";
	$rs_config = mysql_query($qry_config) or die ( mysql_error());
	$row_config = mysql_fetch_array($rs_config);
	
	$amount = 	$row_config[$pid];*/
	
	mysql_query("update tbl_bussiness set affiliateID = '".$affiliateID."', bussStatus = 1, epxiryDate = ".$expiry.", bussType = ".$busstype.", date_modified = ".time()."  where bussId = ".$bussId." ");
	mysql_query("update tblusers set bussLimit  = ".$bussLimit.", STATUS = 'a', lastmodified = ".time()." where id = ".$userId." ");

	mysql_query("delete from tbl_enhancebuss where bussId = '".$bussId."' and userId = '".$userId."'");
	mysql_query("insert into tbl_enhancebuss set bussId = '".$bussId."', userId = '".$userId."', bussType = '".$busstype."'");
	
	$qry = "insert into tbl_paymenthistory set userId = '".$userId."', bussId = '".$bussId."', payment_status = '1', payment_date = '".time()."', 
			payer_id = '".$tId."', paymentType = '3', mc_gross = '".$amount."',  note = '".addslashes($note)."', receiver_id = '".$returnData['receiver_id']."',  dateAdded = '".time()."'";
	
	//exit;
	if(mysql_query($qry))
	{
		$_SESSION['statuss']='Done successfully';
		header("location:".ruadmin."home.php?p=manualpayment&id=".$bussId."&tId=".$tId);
		exit;
	}
	exit;
}
//////////////////////////////Add catogries////////////////////////////////////////////////////////////	
if($p=='categories')
{

   $title=addslashes($_POST['txttitle']);
   $featured=addslashes($_POST['featured']);
   $qrysrc = "select count(id) from  category where cat_name='".$title."'";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['titleerror']='Category already exits.';
	  header("location:".ruadmin."home.php?p=categories");
	  exit;

	}
   $flag=false;
   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Category';
	  header("location:".ruadmin."home.php?p=categories");
	  exit;
   }

   if(!$flg)
	{
		$sql = "INSERT INTO category set cat_name='".$title."' , p_catid=0, featured=".$featured.", cat_type=1";
		mysql_query($sql);
		$catId = mysql_insert_id();
		
		if ( isset($_FILES['cat_image']['tmp_name'])) 
		{ 
			include('../upload.php');		
			$upload_dir = '../media/category/';
			$thumb_folder = '../media/category/thumb/';
			
			$logo ='';			
			chmod($upload_dir,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$photo = "cat_image"; 
		
			$file_type=$_FILES[$photo]['type'];   			
			
			if(!empty($_FILES[$photo]['name']))
			{
				$upload = new upload($photo, $upload_dir, '777', $ext);
				if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
				{
					$photoname=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 126;
					$phpThumb->setSourceFilename($upload_dir.$photoname);
					$output_filename = $thumb_folder.$photoname;

					$phpThumb->setParameter('w', $thumbnail_width);
				if ($phpThumb->GenerateThumbnail()) {
					if ($phpThumb->RenderToFile($output_filename)) {

					}else{

					}
				}else{

				}


				$insQry ="update `category` set 
				img_name = '$photoname' WHERE `catid` = '".$catId."' ";	
				mysql_query($insQry)or die (mysql_error());
				//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
				}else{
					$_SESSION["msg"]["update"] =$upload->message;
				}	
			}
		}
		
		
/*		$qry = "select count(bussId) from tbl_bussiness where kw like('%".$title."%')";
		$qryKcount = mysql_query($qry);
		$rowKcount = mysql_fetch_array($qryKcount);
		mysql_query("update keyword set bussCount = '".$rowKcount[0]."' where id = '".$keyId."' ");*/
		
		$_SESSION['statuss']='Category added successfully';
		header("location:".ruadmin."home.php?p=categories");
		exit;
	}
//
}

/////////////////////////Update Category//////////////////////////////////////////////////////
if($p=='editcategory')
{
	 $sql = "UPDATE category SET cat_name='".$_POST['title']."', featured = ".$_POST['featured']." where catid='".$_GET['cid']."' ";
	mysql_query($sql);
	
	 $sqlbus = "UPDATE business SET industry='".$_POST['title']."' where industry='".$_POST['ctitle']."' ";
	mysql_query($sqlbus);
	
	if ( isset($_FILES['cat_image']['tmp_name'])) 
	{ 
		include('../upload.php');		
		$upload_dir = '../media/category/';
		$thumb_folder = '../media/category/thumb/';
		
		$logo ='';			
		chmod($upload_dir,0777);	
		$ext= array ('gif','jpg','jpeg','png','bmp');			
		$photo = "cat_image"; 
	
		$file_type=$_FILES[$photo]['type'];   			
		
		if(!empty($_FILES[$photo]['name']))
		{
			$upload = new upload($photo, $upload_dir, '777', $ext);
			if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
			{
				$photoname=$upload->filename;					
				require_once('../phpThumb/phpthumb.class.php');
				$phpThumb = new phpThumb();
				$thumbnail_width = 126;
				$phpThumb->setSourceFilename($upload_dir.$photoname);
				$output_filename = $thumb_folder.$photoname;

				$phpThumb->setParameter('w', $thumbnail_width);
			if ($phpThumb->GenerateThumbnail()) {
				if ($phpThumb->RenderToFile($output_filename)) {

				}else{

				}
			}else{

			}


			$insQry ="update `category` set 
			img_name = '$photoname' WHERE `catid` = '".$_GET['cid']."' ";	
			mysql_query($insQry)or die (mysql_error());
			//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
			}else{
				$_SESSION["msg"]["update"] =$upload->message;
			}	
		}
	}
	
	$_SESSION['statuss']='Category Updated successfully';
	header("location:".ruadmin."home.php?p=categories&page=".$_GET['page']);
	exit;
}
	
	/////////////////////////Delet Category//////////////////////////////////////////////////////
if($p=='delcat')
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM category where catid='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Category  Deleted successfully';
		header("location:".ruadmin."home.php?p=categories&page=".$_GET['page']);
		exit;
	}
	exit;
}

/////////////////////////process Claim /////////////////////////////////////////////////////
if($p=='acceptclaim')
{
	
	$uid=$_GET['uid'];
	$bid=$_GET['bid'];
	$bname = base64_decode($_GET['bname']);	
	
	$sqlbiz = "update business set userId=".$uid." where  locationid =".$bid." ";
	mysql_query($sqlbiz);

	$sqlclaim = "update business_claim set status=1 where  locationid =".$bid." ";
	mysql_query($sqlclaim);
	
	$selqry = "select email, firstname, lastname from user where userId=".$uid."";
	$qrycounts = mysql_query($selqry);
	$rowuser = mysql_fetch_array($qrycounts);
	$email = $rowuser['email'];
	$fname = $rowuser['firstname'];
	$lname = $rowuser['lastname'];
		
	$qry="select * from  emails where type ='claimacccpt'"; 
	$rs=mysql_query($qry);
	$row =mysql_fetch_array($rs);
	$adminName=$row['adminname'];
	$toadmin=$row['toadmin'];
	$touser=$row['touser'];
	$subject=$row['subject'];
	$message=$row['body'];
	

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$adminName.' <'.$touser.'>' . "\r\n";
	$headers .= "Content-type: text/html\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "X-Priority: 1\r\n";
	$headers .= "X-MSMail-Priority: High\r\n";

	 
	$message = str_replace('{{FirstName}}' ,$fname , $message);
	$message = str_replace('{{LastName}}' ,$lname , $message);
	
	$message = str_replace('{{Title}}' , $bname , $message);

	$message = nl2br($message);
	
	$mailsent = mail($email,$subject,$message,$headers);	
	$_SESSION['statuss']=" Business claim approved successfully";
	header("location:".ruadmin."home.php?p=claimrequest&page=".$_GET['page']);
	exit;
	
}
if($p=='refuseclaim')
{
	
	$uid=$_GET['uid'];
	$bid=$_GET['bid'];
	$bname = base64_decode($_GET['bname']);	
	
	$sqlbiz = "update business set userId=1 where  locationid =".$bid." ";
	mysql_query($sqlbiz);

	$sqlclaim = "update business_claim set status=2 where  locationid =".$bid." ";
	mysql_query($sqlclaim);

	$selqry = "select email, firstname, lastname from user where userId=".$uid."";
	$qrycounts = mysql_query($selqry);
	$rowuser = mysql_fetch_array($qrycounts);
	$email = $rowuser['email'];
	$fname = $rowuser['firstname'];
	$lname = $rowuser['lastname'];
	
	$qry="select * from  emails where type ='claimrefuse'"; 
	$rs=mysql_query($qry);
	$row =mysql_fetch_array($rs);
	$adminName=$row['adminname'];
	$toadmin=$row['toadmin'];
	$touser=$row['touser'];
	$subject=$row['subject'];
	$message =$row['body'];
	

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$adminName.' <'.$touser.'>' . "\r\n";
	$headers .= "Content-type: text/html\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "X-Priority: 1\r\n";
	$headers .= "X-MSMail-Priority: High\r\n";

 
	$message = str_replace('{{FirstName}}' ,$fname , $message);
	$message = str_replace('{{LastName}}' ,$lname , $message);
	
	$message = str_replace('{{Title}}' , $bname , $message);

	$message = nl2br($message);
	
	$mailsent = mail($email,$subject,$message,$headers);
	
	$_SESSION['statuss']=" Business claim refused successfully";
	header("location:".ruadmin."home.php?p=claimrequest&page=".$_GET['page']);
	exit;
	
}


//////////////////////////////Add catogries////////////////////////////////////////////////////////////	
if($p=='addsubcat')
{

   $title=addslashes($_POST['txttitle']);
   $cat=addslashes($_POST['cat']);
   $qrysrc = "select count(id) from  category where cat_name='".$title."' and p_catid = ".$cat." and cat_type=1";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['titleerror']='Sub Category already exits.';
	  header("location:".ruadmin."home.php?p=category_sub");
	  exit;

	}
   $flag=false;
   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Category';
	  header("location:".ruadmin."home.php?p=category_sub");
	  exit;
   }

   if(!$flg)
	{
		$sql = "INSERT INTO category set cat_name='".$title."' , p_catid = ".$cat.", cat_type=1";
		mysql_query($sql);
		$catId = mysql_insert_id();
		
		$_SESSION['statuss']='Sub Category added successfully';
		header("location:".ruadmin."home.php?p=category_sub");
		exit;
	}
}

/////////////////////////Update Category//////////////////////////////////////////////////////
if($p=='editsubcategory')
{
	$cat=addslashes($_POST['cat']);
	$sql = "UPDATE category SET cat_name='".$_POST['title']."' , p_catid = ".$cat.", cat_type=1 where catid='".$_GET['cid']."' ";
	mysql_query($sql);
	
	$sqlbus = "UPDATE business SET subcat='".$_POST['title']."' where subcat='".$_POST['ctitle']."' ";
	mysql_query($sqlbus);	
	
	$_SESSION['statuss']='Sub Category Updated successfully';
	header("location:".ruadmin."home.php?p=category_sub&page=".$_GET['page']);
	exit;
}
	
	/////////////////////////Delet Category//////////////////////////////////////////////////////
if($p=='delsubcat')
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM category where catid='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Sub Category  Deleted successfully';
		header("location:".ruadmin."home.php?p=category_sub&page=".$_GET['page']);
		exit;
	}
	exit;
}
/////////////////////////Update Package//////////////////////////////////////////////////////
if($p=='updatepackage')
{
	
	$cid=$_GET['cid'];
	$text=trim(addslashes($_POST['text']));
	$sql = "UPDATE norio_monthlypackage set  text='".$text."' where tip_id='1'" ;
	mysql_query($sql);
	$_SESSION['statuss']='Package Updated successfully';
	header("location:".ruadmin."home.php?p=manage_package&page=".$_GET['page']);
	exit;
}

//////////////////////////////Add New Company////////////////////////////////////////////////////////////	
if($p=='companies')
{
   $title=addslashes($_POST['txttitle']);
   $featured=addslashes($_POST['featured']);
   $qrysrc = "select count(id) from  norio_company_types where company_types='".$title."'";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['titleerror']='Company already exits.';
	  header("location:".ruadmin."home.php?p=company_add");
	  exit;

	}
   $flag=false;
   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Company type';
	  header("location:".ruadmin."home.php?p=company_add");
	  exit;
   }

   if(!$flg)
	{
		$sql = "INSERT INTO norio_company_types set company_types='".$title."'";
		mysql_query($sql);
		$catId = mysql_insert_id();
		
		/*if ( isset($_FILES['cat_image']['tmp_name'])) 
		{ 
			include('../upload.php');		
			$upload_dir = '../media/category/';
			$thumb_folder = '../media/category/thumb/';
			
			$logo ='';			
			chmod($upload_dir,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$photo = "cat_image"; 
		
			$file_type=$_FILES[$photo]['type'];   			
			
			if(!empty($_FILES[$photo]['name']))
			{
				$upload = new upload($photo, $upload_dir, '777', $ext);
				if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
				{
					$photoname=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 126;
					$phpThumb->setSourceFilename($upload_dir.$photoname);
					$output_filename = $thumb_folder.$photoname;

					$phpThumb->setParameter('w', $thumbnail_width);
				if ($phpThumb->GenerateThumbnail()) {
					if ($phpThumb->RenderToFile($output_filename)) {

					}else{

					}
				}else{

				}


				$insQry ="update `category` set 
				img_name = '$photoname' WHERE `catid` = '".$catId."' ";	
				mysql_query($insQry)or die (mysql_error());
				//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
				}else{
					$_SESSION["msg"]["update"] =$upload->message;
				}	
			}
		}*/
		
		
/*		$qry = "select count(bussId) from tbl_bussiness where kw like('%".$title."%')";
		$qryKcount = mysql_query($qry);
		$rowKcount = mysql_fetch_array($qryKcount);
		mysql_query("update keyword set bussCount = '".$rowKcount[0]."' where id = '".$keyId."' ");*/
		
		$_SESSION['statuss']='Company added successfully';
		header("location:".ruadmin."home.php?p=company_add");
		exit;
	}
//
}

/////////////////////////Update Company//////////////////////////////////////////////////////
if($p=='editcompany')
{
	 $sql = "UPDATE norio_company_types SET company_types='".$_POST['title']."' where company_id='".$_GET['cid']."' ";
	mysql_query($sql);
	
/*	 $sqlbus = "UPDATE business SET industry='".$_POST['title']."' where industry='".$_POST['ctitle']."' ";
	mysql_query($sqlbus);*/
	
/*	if ( isset($_FILES['cat_image']['tmp_name'])) 
	{ 
		include('../upload.php');		
		$upload_dir = '../media/category/';
		$thumb_folder = '../media/category/thumb/';
		
		$logo ='';			
		chmod($upload_dir,0777);	
		$ext= array ('gif','jpg','jpeg','png','bmp');			
		$photo = "cat_image"; 
	
		$file_type=$_FILES[$photo]['type'];   			
		
		if(!empty($_FILES[$photo]['name']))
		{
			$upload = new upload($photo, $upload_dir, '777', $ext);
			if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
			{
				$photoname=$upload->filename;					
				require_once('../phpThumb/phpthumb.class.php');
				$phpThumb = new phpThumb();
				$thumbnail_width = 126;
				$phpThumb->setSourceFilename($upload_dir.$photoname);
				$output_filename = $thumb_folder.$photoname;

				$phpThumb->setParameter('w', $thumbnail_width);
			if ($phpThumb->GenerateThumbnail()) {
				if ($phpThumb->RenderToFile($output_filename)) {

				}else{

				}
			}else{

			}


			$insQry ="update `category` set 
			img_name = '$photoname' WHERE `catid` = '".$_GET['cid']."' ";	
			mysql_query($insQry)or die (mysql_error());
			//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
			}else{
				$_SESSION["msg"]["update"] =$upload->message;
			}	
		}
	}*/
	
	$_SESSION['statuss']='Company Updated successfully';
	header("location:".ruadmin."home.php?p=company_add&page=".$_GET['page']);
	exit;
}
	
	/////////////////////////Delete Compnay//////////////////////////////////////////////////////
if($p=='delcompany')
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM norio_company_types where company_id='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Company  Deleted successfully';
		header("location:".ruadmin."home.php?p=company_add&page=".$_GET['page']);
		exit;
	}
	exit;
}

//////////////////////////////Add New Loan////////////////////////////////////////////////////////////	
if($p=='loans')
{
   $title=addslashes($_POST['txttitle']);
   $qrysrc = "select count(id) from  norio_loan_types where loan_types='".$title."'";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['titleerror']='Loan already exits.';
	  header("location:".ruadmin."home.php?p=loan_add");
	  exit;

	}
   $flag=false;
   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Loan type';
	  header("location:".ruadmin."home.php?p=loan_add");
	  exit;
   }

   if(!$flg)
	{
		$sql = "INSERT INTO norio_loan_types set loan_types='".$title."'";
		mysql_query($sql);
		$catId = mysql_insert_id();
		
		/*if ( isset($_FILES['cat_image']['tmp_name'])) 
		{ 
			include('../upload.php');		
			$upload_dir = '../media/category/';
			$thumb_folder = '../media/category/thumb/';
			
			$logo ='';			
			chmod($upload_dir,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$photo = "cat_image"; 
		
			$file_type=$_FILES[$photo]['type'];   			
			
			if(!empty($_FILES[$photo]['name']))
			{
				$upload = new upload($photo, $upload_dir, '777', $ext);
				if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
				{
					$photoname=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 126;
					$phpThumb->setSourceFilename($upload_dir.$photoname);
					$output_filename = $thumb_folder.$photoname;

					$phpThumb->setParameter('w', $thumbnail_width);
				if ($phpThumb->GenerateThumbnail()) {
					if ($phpThumb->RenderToFile($output_filename)) {

					}else{

					}
				}else{

				}


				$insQry ="update `category` set 
				img_name = '$photoname' WHERE `catid` = '".$catId."' ";	
				mysql_query($insQry)or die (mysql_error());
				//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
				}else{
					$_SESSION["msg"]["update"] =$upload->message;
				}	
			}
		}*/
		
		
/*		$qry = "select count(bussId) from tbl_bussiness where kw like('%".$title."%')";
		$qryKcount = mysql_query($qry);
		$rowKcount = mysql_fetch_array($qryKcount);
		mysql_query("update keyword set bussCount = '".$rowKcount[0]."' where id = '".$keyId."' ");*/
		
		$_SESSION['statuss']='Loan added successfully';
		header("location:".ruadmin."home.php?p=loan_add");
		exit;
	}
//
}

/////////////////////////Update Loan//////////////////////////////////////////////////////
if($p=='editloan')
{
	 $sql = "UPDATE norio_loan_types SET loan_types='".$_POST['title']."' where loan_id='".$_GET['cid']."' ";
	mysql_query($sql);
	
/*	 $sqlbus = "UPDATE business SET industry='".$_POST['title']."' where industry='".$_POST['ctitle']."' ";
	mysql_query($sqlbus);*/
	
/*	if ( isset($_FILES['cat_image']['tmp_name'])) 
	{ 
		include('../upload.php');		
		$upload_dir = '../media/category/';
		$thumb_folder = '../media/category/thumb/';
		
		$logo ='';			
		chmod($upload_dir,0777);	
		$ext= array ('gif','jpg','jpeg','png','bmp');			
		$photo = "cat_image"; 
	
		$file_type=$_FILES[$photo]['type'];   			
		
		if(!empty($_FILES[$photo]['name']))
		{
			$upload = new upload($photo, $upload_dir, '777', $ext);
			if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
			{
				$photoname=$upload->filename;					
				require_once('../phpThumb/phpthumb.class.php');
				$phpThumb = new phpThumb();
				$thumbnail_width = 126;
				$phpThumb->setSourceFilename($upload_dir.$photoname);
				$output_filename = $thumb_folder.$photoname;

				$phpThumb->setParameter('w', $thumbnail_width);
			if ($phpThumb->GenerateThumbnail()) {
				if ($phpThumb->RenderToFile($output_filename)) {

				}else{

				}
			}else{

			}


			$insQry ="update `category` set 
			img_name = '$photoname' WHERE `catid` = '".$_GET['cid']."' ";	
			mysql_query($insQry)or die (mysql_error());
			//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
			}else{
				$_SESSION["msg"]["update"] =$upload->message;
			}	
		}
	}*/
	
	$_SESSION['statuss']='Loan Updated successfully';
	header("location:".ruadmin."home.php?p=loan_add&page=".$_GET['page']);
	exit;
}
	
	/////////////////////////Delete Loan//////////////////////////////////////////////////////
if($p=='delloan')
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM norio_loan_types where loan_id='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Loan  Deleted successfully';
		header("location:".ruadmin."home.php?p=loan_add&page=".$_GET['page']);
		exit;
	}
	exit;
}

//////////////////////////////Add New Lender type////////////////////////////////////////////////////////////	
if($p=='lendertypes')
{
   $title=addslashes($_POST['txttitle']);
   $qrysrc = "select count(id) from  norio_lender_types where lender_types='".$title."'";
   $qryKcounts = mysql_query($qrysrc);
   $rowKcounts = mysql_fetch_array($qryKcounts);
   $flag=false;
	if($rowKcounts[0]> 0){
	  $flag=true;
	  $_SESSION['titleerror']='Lender type already exits.';
	  header("location:".ruadmin."home.php?p=lender_add");
	  exit;

	}
   $flag=false;
   if(!$title)
   {
	  $flag=true;
	  $_SESSION['titleerror']='Please Enter Lender type';
	  header("location:".ruadmin."home.php?p=lender_add");
	  exit;
   }

   if(!$flg)
	{
		$sql = "INSERT INTO norio_lender_types set lender_types='".$title."'";
		mysql_query($sql);
		$catId = mysql_insert_id();
		
		/*if ( isset($_FILES['cat_image']['tmp_name'])) 
		{ 
			include('../upload.php');		
			$upload_dir = '../media/category/';
			$thumb_folder = '../media/category/thumb/';
			
			$logo ='';			
			chmod($upload_dir,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$photo = "cat_image"; 
		
			$file_type=$_FILES[$photo]['type'];   			
			
			if(!empty($_FILES[$photo]['name']))
			{
				$upload = new upload($photo, $upload_dir, '777', $ext);
				if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
				{
					$photoname=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 126;
					$phpThumb->setSourceFilename($upload_dir.$photoname);
					$output_filename = $thumb_folder.$photoname;

					$phpThumb->setParameter('w', $thumbnail_width);
				if ($phpThumb->GenerateThumbnail()) {
					if ($phpThumb->RenderToFile($output_filename)) {

					}else{

					}
				}else{

				}


				$insQry ="update `category` set 
				img_name = '$photoname' WHERE `catid` = '".$catId."' ";	
				mysql_query($insQry)or die (mysql_error());
				//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
				}else{
					$_SESSION["msg"]["update"] =$upload->message;
				}	
			}
		}*/
		
		
/*		$qry = "select count(bussId) from tbl_bussiness where kw like('%".$title."%')";
		$qryKcount = mysql_query($qry);
		$rowKcount = mysql_fetch_array($qryKcount);
		mysql_query("update keyword set bussCount = '".$rowKcount[0]."' where id = '".$keyId."' ");*/
		
		$_SESSION['statuss']='Lender type added successfully';
		header("location:".ruadmin."home.php?p=lender_add");
		exit;
	}
//
}

/////////////////////////Update Loan//////////////////////////////////////////////////////
if($p=='editlendertypes')
{
	 $sql = "UPDATE norio_lender_types SET lender_types='".$_POST['title']."' where lender_id='".$_GET['cid']."' ";
	mysql_query($sql);
	
/*	 $sqlbus = "UPDATE business SET industry='".$_POST['title']."' where industry='".$_POST['ctitle']."' ";
	mysql_query($sqlbus);*/
	
/*	if ( isset($_FILES['cat_image']['tmp_name'])) 
	{ 
		include('../upload.php');		
		$upload_dir = '../media/category/';
		$thumb_folder = '../media/category/thumb/';
		
		$logo ='';			
		chmod($upload_dir,0777);	
		$ext= array ('gif','jpg','jpeg','png','bmp');			
		$photo = "cat_image"; 
	
		$file_type=$_FILES[$photo]['type'];   			
		
		if(!empty($_FILES[$photo]['name']))
		{
			$upload = new upload($photo, $upload_dir, '777', $ext);
			if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
			{
				$photoname=$upload->filename;					
				require_once('../phpThumb/phpthumb.class.php');
				$phpThumb = new phpThumb();
				$thumbnail_width = 126;
				$phpThumb->setSourceFilename($upload_dir.$photoname);
				$output_filename = $thumb_folder.$photoname;

				$phpThumb->setParameter('w', $thumbnail_width);
			if ($phpThumb->GenerateThumbnail()) {
				if ($phpThumb->RenderToFile($output_filename)) {

				}else{

				}
			}else{

			}


			$insQry ="update `category` set 
			img_name = '$photoname' WHERE `catid` = '".$_GET['cid']."' ";	
			mysql_query($insQry)or die (mysql_error());
			//$_SESSION['msg']['update'] = 'Your photo uploaded successfully!';	
			}else{
				$_SESSION["msg"]["update"] =$upload->message;
			}	
		}
	}*/
	
	$_SESSION['statuss']='Lender type Updated successfully';
	header("location:".ruadmin."home.php?p=lender_add&page=".$_GET['page']);
	exit;
}
	
	/////////////////////////Delete Lender//////////////////////////////////////////////////////
if($p=='dellendertypes')
{
	$cid=$_GET['cid'];
	$sql = "DELETE FROM norio_lender_types where lender_id='".$cid."'";
	if(mysql_query($sql))
	{
		$_SESSION['statuss']='Lender type  Deleted successfully';
		header("location:".ruadmin."home.php?p=lender_add&page=".$_GET['page']);
		exit;
	}
	exit;
}
////////////////////////////////add new state /////////////////////////////////////////
	if($p=='addnewstate')
	{
	
 
		$state=trim(addslashes($_POST['Region']));
		$state= ucwords($state);
		if($Region=='')
		{
		  $flag=true;
		 $_SESSION['Regionerror']='Please enter  County';
		}
	
	
		if($flag)
		{
		 header("location:".ruadmin."home.php?p=managestate");
		  exit;
		}
	
		$sql = "INSERT INTO norio_state set statename='".$state."'";
		$db->query($sql);
		$_SESSION['statuss']='State added successfully';
		header("location:".ruadmin."home.php?p=managestate");
		exit;
		
	}
////////////////////////////////Edit new state /////////////////////////////////////////
	if($p=='editnewState')
	{
	
		$state=trim(addslashes($_POST['Region']));
		$state= ucwords($state);
		if($Region=='')
		{
		  $flag=true;
		 $_SESSION['Regionerror']='Please enter  County';
		}
	
	
		if($flag)
		{
		 header("location:".ruadmin."home.php?p=managestate");
		  exit;
		}
		$stateid=$_GET['cid'];
	
		$sql = "UPDATE  norio_state set statename='".$state."' where stateid='$stateid'";
		$db->query($sql);

		$_SESSION['statuss']='State Updated successfully';
		header("location:".ruadmin."home.php?p=managestate");
		exit;
		
	}
	
   //---------------Delete State-----------------------//
	
	if($p=='delnewState')
	{
		$cid=$_GET['cid'];
		$sql = "DELETE FROM norio_state where stateid=".$cid;
			
		if($db->query($sql))
		{
			$_SESSION['statuss']='State Deleted successfully';
			header("location:".ruadmin."home.php?p=managestate");
			exit;
		}
		exit;
	}		


?>