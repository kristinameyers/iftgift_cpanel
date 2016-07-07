<?php 
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');

unset($_SESSION['biz_pattren_pallet_err']);
unset($_SESSION['biz_pattren_pallet']);
//print_r($_REQUEST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$Id  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from pattren_pallet where Id  = $Id ");
	
		$_SESSION['biz_pattren_pallet_err']['pattren_pallets'] = 'Pattren pallet deleted !';
		header('location:'.ruadmin.'home.php?p=pattren_pallet'); exit;			
	
	} 


if (isset($_POST['SavePattrenpallet'])){ 
		
		//echo "<pre>"; print_r($_POST); exit;
		
     	unset($_SESSION['biz_pattren_pallet_err']);
	    unset($_SESSION['biz_pattren_pallet']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['biz_pattren_pallet'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_pattren_pallet_err']['name'] = 'Please enter pattren pallet name';
		$flgs = true;
	
	}
	
	 
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=pattren_pallet'); exit;
		
  }else{

   			$insQry ="insert into pattren_pallet set name ='$name',
											pId1  = '$pId1',
											pId2  = '$pId2',
											pId3  = '$pId3',
											pId4  = '$pId4',
											pId5  = '$pId5',
											pId6  = '$pId6',
											pId7  = '$pId7',
											pId8  = '$pId8',
											pId9  = '$pId9',
											pId10  = '$pId10',
											pId11  = '$pId11',
											pId12  = '$pId12',
											pId13  = '$pId13',
											pId14  = '$pId14',
											pId15  = '$pId15',
											pId16  = '$pId16',
											pId17  = '$pId17',
											pId18  = '$pId18',
											pId19  = '$pId19',
											pId20  = '$pId20',
											pId21  = '$pId21',
											pId22  = '$pId22',
											pId23  = '$pId23',
											pId24  = '$pId24',
											pId25  = '$pId25',
											pId26  = '$pId26',
											pId27  = '$pId27',
											pId28  = '$pId28',
											pId29  = '$pId29',
											pId30  = '$pId30',
											dated = now()";
  		 mysql_query($insQry)or die (mysql_error());
		
		unset($_SESSION['biz_pattren_pallet_err']);
		unset($_SESSION['biz_pattren_pallet']);
		$_SESSION['biz_pattren_pallet_err']['pattren_pallets'] = 'Pattren Pallet added successfully!';
		header('location:'.ruadmin.'home.php?p=pattren_pallet'); exit;
  }
  
}

if ( isset ($_POST['UpdatePattrenpallet'])){
//print_r($_REQUEST); exit;
	    unset($_SESSION['biz_pattren_pallet_err']);
	    unset($_SESSION['biz_pattren_pallet']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(trim($v ));
			$_SESSION['biz_pattren_pallet'][$k]=$v;
		}
	$flgs = false;
	
		///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_pattren_pallet_err']['name'] = 'Please enter pattren pallet name';
		$flgs = true;
	
	}
		
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=pattren_pallet'); exit;
		
  }else{
  		

 		$insQry2 ="Update pattren_pallet set name ='$name',
									pId1  = '$pId1',
									pId2  = '$pId2',
									pId3  = '$pId3',
									pId4  = '$pId4',
									pId5  = '$pId5',
									pId6  = '$pId6',
									pId7  = '$pId7',
									pId8  = '$pId8',
									pId9  = '$pId9',
									pId10  = '$pId10',
									pId11  = '$pId11',
									pId12  = '$pId12',
									pId13  = '$pId13',
									pId14  = '$pId14',
									pId15  = '$pId15',
									pId16  = '$pId16',
									pId17  = '$pId17',
									pId18  = '$pId18',
									pId19  = '$pId19',
									pId20  = '$pId20',
									pId21  = '$pId21',
									pId22  = '$pId22',
									pId23  = '$pId23',
									pId24  = '$pId24',
									pId25  = '$pId25',
									pId26  = '$pId26',
									pId27  = '$pId27',
									pId28  = '$pId28',
									pId29  = '$pId29',
									pId30  = '$pId30',
									dated = now()
									where Id =$Id";
  		mysql_query($insQry2)or die (mysql_error());

		unset($_SESSION['biz_pattren_pallet_err']);
		unset($_SESSION['biz_pattren_pallet']);
		$_SESSION['biz_pattren_pallet_err']['pattren_pallets'] = 'Pattren pallet updated successfully!';
		header('location:'.ruadmin.'home.php?p=pattren_pallet'); exit;
  }
}

?>