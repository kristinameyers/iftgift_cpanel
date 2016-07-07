<?php 
require_once("../../connect/connect.php");
require_once("../../config/config.php");
require_once("../security.php");
require_once ('../inc/functii.php');
include ("../inc/upload.php");

unset($_SESSION['biz_pro_err']);
unset($_SESSION['biz_pro']);
//echo "<pre>";
//print_r($_POST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
	 $Id  =$_GET['Id'];
	
	 $biz_Sql = mysql_query("delete from ".tbl_product." where proid  = $Id "); 
	
		$_SESSION['msg'] = 'Product deleted!';
		header('location:'.ruadmin.'home.php?p=product_manage&page='.$_GET['page']); exit;				
	
	} 

///////////////////////////////////DELETE MULTIPLE Values//////////////////////////////////////////
if ( $_REQUEST['type']=='Delete')
{
	$proid = explode(',',$_POST['proid']);
	foreach($proid as $pId){
		mysql_query("DELETE FROM ".tbl_product." WHERE proid = '".$pId."'");
    	$_SESSION['msg'] = 'Product deleted!';
		echo '1';
	}	
} 
///////////////////////////////////DELETE MULTIPLE Values//////////////////////////////////////////
if (isset($_POST['SaveProduct'])){ 

     	unset($_SESSION['biz_pro_err']);
	    unset($_SESSION['biz_pro']);
	
	foreach ($_POST as $k => $v ){
		$$k =  addslashes(trim($v ));
		$_SESSION['biz_pro'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name validation////////	
	
	if($pro_name==''){
		$_SESSION['biz_pro_err']['pro_name'] = 'Please enter product name';
		$flgs = true;
	
	}
	
	if($price==''){
		$_SESSION['biz_pro_err']['price'] = 'Please enter product price';
		$flgs = true;
	
	}
	  
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=product_add'); exit;
		
  }else{

   			  $insQry ="insert into ".tbl_product." set pro_name = '$pro_name',
			  									pro_cat		= '$category',
			 									short_description 		= '$short_description',
												long_description 		= '$long_description',
												price   	= '$price',
												status      = '$status',
												userId= '$userId',
												dated 		= now()";
  		 mysql_query($insQry)or die (mysql_error());
		
		$proId = mysql_insert_id();		
		
		if ( isset($_FILES['image']['tmp_name'])) 
		{ 
		
			@mkdir ('../media/'.$proId ,0777) ;
			@mkdir ('../media/'.$proId.'/product_image/' , 0777);
			@mkdir ('../media/'.$proId.'/product_image/thumb/', 0777);
		
			$upload_dir = '../media/'.$proId.'/product_image/';
			$thumb_folder = '../media/'.$proId.'/product_image/thumb/';
			
			$logo ='';			
			@chmod($upload_dir,0777);	
			@chmod($thumb_folder,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$companylogo = "image"; 
		
			$file_type=$_FILES[$companylogo]['type'];   			
			if(!empty($_FILES[$companylogo]['name']))
			{
				$upload = new upload($companylogo, $upload_dir, '777', $ext);
				//echo '<pre>';print_r($upload);exit;
					$logo=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 75;
					$phpThumb->setSourceFilename($upload_dir.$logo);
					$output_filename = $thumb_folder.$logo;
					
					// set parameters (see "URL Parameters" in phpthumb.readme.txt)
					$phpThumb->setParameter('w', $thumbnail_width);
					
					// generate & output thumbnail
					if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
					if ($phpThumb->RenderToFile($output_filename)) {
						// do something on success
						//echo 'Successfully rendered to "'.$output_filename.'"';
					} 
				} 

			}
		}
		
		mysql_query("update ".tbl_product." set image='$logo' where proid = '$proId'");
		
		unset($_SESSION['biz_pro_err']);
		unset($_SESSION['biz_pro']);
		$_SESSION['biz_pro_err']['Product_add'] = 'Product added successfully!';
		header('location:'.ruadmin.'home.php?p=product_add'); exit;
  }
  
}


if ( isset ($_POST['UpdateProduct'])){

//echo "<pre>";
//print_r($_POST);exit;

	    unset($_SESSION['biz_pro_err']);
	    unset($_SESSION['biz_pro']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(@trim($v ));
			$_SESSION['biz_pro'][$k]=$v;
		}

			if ( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='') 
			{ 
				
				@mkdir ('../media/'.$proid ,0777) ;
				@mkdir ('../media/'.$proid.'/product_image/' , 0777);
				@mkdir ('../media/'.$proid.'/product_image/thumb/', 0777);
		
				$upload_dir = '../media/'.$proid.'/product_image/';
				$thumb_folder = '../media/'.$proid.'/product_image/thumb/';
				
				$logo ='';
				chmod($upload_dir,0777);
				chmod($thumb_folder,0777);	
				$ext= array ('gif','jpg','jpeg','png','bmp','GIF','JPG','JPEG','PNG','BMP');
				
				$companylogo = "image"; 
			
				$file_type=$_FILES[$companylogo]['type'];   
				
				if(!empty($_FILES[$companylogo]['name']))
				{
					$upload = new upload($companylogo, $upload_dir, '777', $ext);
					//echo '<pre>';print_r($upload);exit;
					if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
					{
						$logo=$upload->filename;					
						require_once('../phpThumb/phpthumb.class.php');
						$phpThumb = new phpThumb();
						$thumbnail_width = 75;
						$phpThumb->setSourceFilename($upload_dir.$logo);
						$output_filename = $thumb_folder.$logo;
						// set parameters (see "URL Parameters" in phpthumb.readme.txt)
						$phpThumb->setParameter('w', $thumbnail_width);
						// generate & output thumbnail
						if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
							if ($phpThumb->RenderToFile($output_filename)) {
							// do something on success
							//echo 'Successfully rendered to "'.$output_filename.'"';
							} 
						} 
						@unlink ($upload_dir.$oldlogofile);
						@unlink ($thumb_folder.$oldlogofile);
						$insQry ="update  ".tbl_product." set image ='$logo' where proid = $proid";	
						mysql_query($insQry)or die (mysql_error());
						
						
							
					}else{
						$_SESSION["biz_pro"]["image"] = "Error: Upload an Image file.";
					}	
				}
	
		} else {
		
			$logo = $_POST['oldlogo'];
			
			}
			
	$flgs = false;

		///////////////////////name validation////////	
	
	if($pro_name==''){
		$_SESSION['biz_pro_err']['pro_name'] = 'Please enter product name';
		$flgs = true;
	
	}
	
	if($price==''){
		$_SESSION['biz_pro_err']['price'] = 'Please enter product price';
		$flgs = true;
	
	}
	
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=product_edit&Id='.$proid); exit;
		
  }else{
  		

 		$insQry2 ="Update ".tbl_product." set 	pro_name	    = '$pro_name',
										pro_cat		= '$category',
										short_description 		= '$short_description',
										long_description 		= '$long_description',
										price   	= '$price',
										status      = '$status',
										userId= '$userId',
										dated		= now()
										where proid 	= $proid";
										
  		mysql_query($insQry2)or die (mysql_error());
		
		
		unset($_SESSION['biz_pro_err']);
		unset($_SESSION['biz_pro']);
		$_SESSION['biz_pro_err']['Product_add'] = 'Product Updated Successfully!';
		header('location:'.ruadmin.'home.php?p=product_edit&Id='.$proid); exit;
  }
}


function keywordsclean($kwname){
	$kwname = str_replace(", &",",",$kwname);
	$kwname = str_replace(",&",",",$kwname);
	$kwname = str_replace(" , ",",",$kwname);
	$kwname = str_replace(", ",",",$kwname);
	$kwname = str_replace(" ,",",",$kwname);	
	$kwname =str_replace("?","",$kwname);
	$kwname =str_replace(":","",$kwname);	
	$kwname =str_replace(";","",$kwname);		
	$kwname =str_replace("'","",$kwname);
	$kwname =str_replace("/"," ",$kwname);
	$kwname =str_replace("  "," ",$kwname);	
	return $kwname;
}
?>