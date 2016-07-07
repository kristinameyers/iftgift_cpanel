<?php 
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');
include ("../inc/upload.php");
$banner_id=$_GET['banner_id'];

if($_GET['banner_id']){
	$banner_id=$_GET['banner_id'];
	$select_banner_query="select * from banner where id='".$banner_id."'";
	$row_banner=$db->get_row($select_banner_query , ARRAY_A);
	
	$de_dir='../media/banner/'.$row_banner['image'];
	$de_dir2='../media/banner/thumb'.$row_banner['image'];
	
	if(is_dir($de_dir)){
	
		recursive_remove_directory($de_dir);
		recursive_remove_directory($de_dir2);
	}
	$del_exib="delete from  banner where id=$banner_id";
	$db->query($del_exib);
	$_SESSION['success']['delete'] = "Banner has been successfully deleted";
	header('location:'.ruadmin.'home.php?p=banner_manage');
	exit;
}

if(isset($_POST['Add_banner'])){
	unset($_SESSION['error_image']);
	unset($_SESSION['add_image']);
		foreach($_POST as $key=>$val){
			//$$key=$val;
			$$key=addslashes(trim($val));
			$_SESSION['add_image'][$key]=$val;
		}
		$flgs=false;
	//	echo '<pre>';print_r($_POST);exit;
		if($url==''){
			$_SESSION['error_image']['url']='please Enter url';
			$flgs=true;
		}
		
		if($flgs){
			header('location:'.ruadmin.'home.php?p=banner_add'); 
			exit;
		}
		else{
		$qry_image ="Insert into banner  set url ='$url',status ='$status'";
		$db->query($qry_image);
		$banner_image_id = mysql_insert_id();
		
		
		
		
		if($_FILES['image']['name']){
		$filepath = '../media/banner/';
		@mkdir($filepath,0777);
		$thumbfilepath ='../media/banner/thumb/';
		@mkdir($thumbfilepath,0777) ;
		$ext= array ('gif','jpg','jpeg','png','bmp');
		$upload= new upload('image',$filepath,777,$ext);
			if($upload->message=="SUCCESS_FILE_SAVED_SUCCESSFULLY"){
				$photo=$upload->filename;
				require_once('../phpThumb/phpthumb.class.php');
				$phpThumb=new phpthumb();
				$thumbnail_width = 120;
				$phpThumb->setSourceFilename($filepath.$photo);
				$output_filename = $thumbfilepath.$photo;
				$phpThumb->setParameter('w', $thumbnail_width);
				if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
					$phpThumb->RenderToFile($output_filename);
				} 
				$query="update banner set image ='".$photo."' where id=$banner_image_id";			
				$db->query($query);
				
				}
			}
		
		
		unset($_SESSION['add_image']);
		unset($_SESSION['error_image']);
		$_SESSION['success']['save'] = "Banner has been successfully added";
		header('location:'.ruadmin.'home.php?p=banner_manage');
		exit; 
		
		}	
		}
		if(isset($_POST['Update_banner'])){
	unset($_SESSION['image_edit']);
	unset($_SESSION['error_image']);
		foreach($_POST as $key=>$val){
			$$key=$val;
			$$key=addslashes(trim($val));
			$_SESSION['image_edit'][$key]=$val;
		}
		$flgs=false;
		
	//	echo '<pre>';print_r($_POST);print_r($_FILES);exit;
		if($url==''){
			$_SESSION['error_image']['url']='please Enter url';
			$flgs=true;
		}
		if($flgs){
			header('location:'.ruadmin.'home.php?p=banner_edit&banner_id='.$banner_id); 
			exit;
		}
		else{
		$qry_banner_edit ="update banner  set url ='$url',status ='$status' where id = '".$banner_id."'";
	
		$db->query($qry_banner_edit);
			
			/////////////////file upload///////////////////////
	if($_FILES['image']['name']){
		$do = unlink("../media/banner/".$oldimage);
		$filepath = '../media/banner/';
		
		@mkdir($filepath,0777);
		$do1 = unlink("../media/banner/thumb/".$oldimage);
		$thumbfilepath = '../media/banner/thumb/';
		@mkdir($thumbfilepath,0777) ;
		$ext= array ('gif','jpg','jpeg','png','bmp');
		$upload= new upload('image',$filepath,777,$ext);
			if($upload->message=="SUCCESS_FILE_SAVED_SUCCESSFULLY"){
				$photo=$upload->filename;
				require_once('../phpThumb/phpthumb.class.php');
				$phpThumb=new phpthumb();
				$thumbnail_width = 120;
				$phpThumb->setSourceFilename($filepath.$photo);
				$output_filename = $thumbfilepath.$photo;
				$phpThumb->setParameter('w', $thumbnail_width);
				if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
					$phpThumb->RenderToFile($output_filename);
				} 
				$query="update banner set image ='".$photo."' where id=$banner_id";			
				
				$db->query($query);
				
				}
			}
		////////////////////////////////end of Upload file /////////////
				
		unset($_SESSION['image_edit']);
		unset($_SESSION['error_image']);
		$_SESSION['success']['save'] = "Banner has been successfully Updated";
		header('location:'.ruadmin.'home.php?p=banner_manage'); 
		exit;
		}
			
}	

?>