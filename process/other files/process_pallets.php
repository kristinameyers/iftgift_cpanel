<?php 
require_once("../../connect/connect.php");
require_once("../security.php");
require_once ('../inc/functii.php');

unset($_SESSION['biz_pallet_err']);
unset($_SESSION['biz_pallet']);
//print_r($_REQUEST); exit;
if ( isset ($_GET['action'])  and  ($_GET['action']=='d'))
{
			
	$Id  =$_GET['Id'];

	$biz_Sql = mysql_query("delete from pallet where Id  = $Id ");
	
		$_SESSION['biz_pallet_err']['pallets'] = 'Pallet deleted !';
		header('location:'.ruadmin.'home.php?p=pallet'); exit;			
	
	} 


if (isset($_POST['Savepallet'])){ 

     	unset($_SESSION['biz_pallet_err']);
	    unset($_SESSION['biz_pallet']);
	
	foreach ($_POST as $k => $v ){
		$$k =  $v;
		$_SESSION['biz_pallet'][$k]=$v;
	}
  	$flgs = false;


	///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_pallet_err']['name'] = 'Please enter pallet name';
		$flgs = true;
	
	}
	
	 
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=pallet'); exit;
		
  }else{

   			$insQry ="insert into pallet set name ='$name',
											cId1  = '$cId1',
											cId2  = '$cId2',
											cId3  = '$cId3',
											cId4  = '$cId4',
											cId5  = '$cId5',
											cId6  = '$cId6',
											cId7  = '$cId7',
											cId8  = '$cId8',
											cId9  = '$cId9',
											cId10  = '$cId10',
											cId11  = '$cId11',
											cId12  = '$cId12',
											cId13  = '$cId13',
											cId14  = '$cId14',
											cId15  = '$cId15',
											cId16  = '$cId16',
											cId17  = '$cId17',
											cId18  = '$cId18',
											cId19  = '$cId19',
											cId20  = '$cId20',
											cId21  = '$cId21',
											cId22  = '$cId22',
											cId23  = '$cId23',
											cId24  = '$cId24',
											cId25  = '$cId25',
											cId26  = '$cId26',
											cId27  = '$cId27',
											cId28  = '$cId28',
											cId29  = '$cId29',
											cId30  = '$cId30',
											dated = now()";
  		 mysql_query($insQry)or die (mysql_error());
		
		unset($_SESSION['biz_pallet_err']);
		unset($_SESSION['biz_pallet']);
		$_SESSION['biz_pallet_err']['pallets'] = 'Pallet added successfully!';
		header('location:'.ruadmin.'home.php?p=pallet'); exit;
  }
  
}

if ( isset ($_POST['Updatepallet'])){
//print_r($_REQUEST); exit;
	    unset($_SESSION['biz_pallet_err']);
	    unset($_SESSION['biz_pallet']);
	
		foreach ($_POST as $k => $v ){
			$$k =  addslashes(trim($v ));
			$_SESSION['biz_pallet'][$k]=$v;
		}
	$flgs = false;
	
		///////////////////////name valIdation////////	
	if($name==''){
		$_SESSION['biz_pallet_err']['name'] = 'Please enter pallet name';
		$flgs = true;
	
	}
		
  if($flgs)
  {
	
		header('location:'.ruadmin.'home.php?p=pallet'); exit;
		
  }else{
  		

 		$insQry2 ="Update pallet set name ='$name',
									cId1  = '$cId1',
									cId2  = '$cId2',
									cId3  = '$cId3',
									cId4  = '$cId4',
									cId5  = '$cId5',
									cId6  = '$cId6',
									cId7  = '$cId7',
									cId8  = '$cId8',
									cId9  = '$cId9',
									cId10  = '$cId10',
									cId11  = '$cId11',
									cId12  = '$cId12',
									cId13  = '$cId13',
									cId14  = '$cId14',
									cId15  = '$cId15',
									cId16  = '$cId16',
									cId17  = '$cId17',
									cId18  = '$cId18',
									cId19  = '$cId19',
									cId20  = '$cId20',
									cId21  = '$cId21',
									cId22  = '$cId22',
									cId23  = '$cId23',
									cId24  = '$cId24',
									cId25  = '$cId25',
									cId26  = '$cId26',
									cId27  = '$cId27',
									cId28  = '$cId28',
									cId29  = '$cId29',
									cId30  = '$cId30',
									dated = now()
									where Id =$Id";
  		mysql_query($insQry2)or die (mysql_error());

		unset($_SESSION['biz_pallet_err']);
		unset($_SESSION['biz_pallet']);
		$_SESSION['biz_pallet_err']['pallets'] = 'Pallet updated successfully!';
		header('location:'.ruadmin.'home.php?p=pallet'); exit;
  }
}

?>