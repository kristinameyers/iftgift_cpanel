<?php 
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');
include ("../inc/upload.php");

unset($_SESSION['biz_image_err']);
unset($_SESSION['biz_image']);
//print_r($_REQUEST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$Id  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from cms_images where Id  = $Id ");
	
		$_SESSION['biz_image_err']['images'] = 'image deleted !';
		header('location:'.ruadmin.'home.php?p=cms_images'); exit;			
	
	} 


if (isset($_POST['Saveimage'])){ 

     	unset($_SESSION['biz_image_err']);
	    unset($_SESSION['biz_image']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['biz_image'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_image_err']['name'] = 'Please enter image name';
		$flgs = true;
	
	}
	
	 
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=cms_images'); exit;
		
  }else{

   			$insQry ="insert into cms_images set name  ='$name',
											pageId  = '$page',
											dated = now()";
  		 mysql_query($insQry)or die (mysql_error());
		
		$imgId = mysql_insert_id();	
		
		if ( isset($_FILES['logo']['tmp_name'])) 
		{ 
		

			mkdir ('../media/cms/' ,0777) ;
			mkdir ('../media/cms/thumb/', 0777);
		
			$upload_dir = '../media/cms/';
			$thumb_folder = '../media/cms/thumb/';
			
			$logo ='';			
			chmod($upload_dir,0777);	
			chmod($thumb_folder,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp');			
			$companylogo = "logo"; 
		
			$file_type=$_FILES[$companylogo]['type'];   			
			if(!empty($_FILES[$companylogo]['name']))
			{
				$upload = new upload($companylogo, $upload_dir, '777', $ext);
				if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
				{
					$logo=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 100;
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
					$insQry1 ="update cms_images set logo ='$logo' where Id = '$imgId'";
					mysql_query($insQry1)or die (mysql_error());
					
					}else{
					$_SESSION["biz_pro"]["logo"] = "Error: Upload an Image file.";
					}	
			}
		}	
		
		unset($_SESSION['biz_image_err']);
		unset($_SESSION['biz_image']);
		$_SESSION['biz_image_err']['images'] = 'Image added successfully!';
		header('location:'.ruadmin.'home.php?p=cms_images'); exit;
  }
  
}

if ( isset ($_POST['Updateimage'])){
//print_r($_REQUEST); exit;
	    unset($_SESSION['biz_image_err']);
	    unset($_SESSION['biz_image']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(trim($v ));
			$_SESSION['biz_image'][$k]=$v;
		}
		
		
		if ( isset($_FILES['logo']['tmp_name']) && $_FILES['logo']['tmp_name']!='') 
		{ 
			
			@mkdir ('../media/cms/',0777) ;
			@mkdir ('../media/cms/thumb/', 0777);
			
			$upload_dir = '../media/cms/';
			$thumb_folder = '../media/cms/thumb/';
			
			$logo ='';
			chmod($upload_dir,0777);
			chmod($thumb_folder,0777);	
			$ext= array ('gif','jpg','jpeg','png','bmp','GIF','JPG','JPEG','PNG','BMP');
			
			$companylogo = "logo"; 
		
			$file_type=$_FILES[$companylogo]['type'];   
			
			if(!empty($_FILES[$companylogo]['name']))
			{
				$upload = new upload($companylogo, $upload_dir, '777', $ext);
				if ($upload->message =="SUCCESS_FILE_SAVED_SUCCESSFULLY" )
				{
					$logo=$upload->filename;					
					require_once('../phpThumb/phpthumb.class.php');
					$phpThumb = new phpThumb();
					$thumbnail_width = 100;
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
					//$insQry ="update  Product set 	logo ='$logo' where Id	= $proId";	
					//mysql_query($insQry)or die (mysql_error());
					
					
						
				}else{
					$_SESSION["biz_pro"]["logo"] = "Error: Upload an Image file.";
				}	
			}

	} else {
	
	$logo = $_POST['oldlogo'];
	
	}
		
		
	$flgs = false;
	
		///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_image_err']['name'] = 'Please enter image name';
		$flgs = true;
	
	}

		
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=cms_images'); exit;
		
  }else{
  		

 		$insQry2 ="Update cms_images set name = '$name',
										logo  = '$logo',
										dated = now()
										where Id = '$Id'";
  		mysql_query($insQry2)or die (mysql_error());

		unset($_SESSION['biz_image_err']);
		unset($_SESSION['biz_image']);
		$_SESSION['biz_image_err']['images'] = 'Image Updated Successfully!';
		header('location:'.ruadmin.'home.php?p=cms_images'); exit;
  }
}

?>