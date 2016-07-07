<?php 
	include ('../connect/connect.php');
	
	
	if($_SESSION['adminLogin'] == 'True' )	
	{	
	 	header("location:".ruadmin."home.php");
	} else{
		session_destroy();
	}
	
	if (isset ( $_REQUEST['msg']))  $msg = base64_decode( $_REQUEST['msg'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>iftGift</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="resources/login.css" rel="stylesheet" type="text/css" />
</head>
<body>

<!--<div id="logo">
VerifiedLenders.com cPanel
</div>-->

<div class="box">
     <div class="welcome" id="welcometitle">iftGift, Please Login:</div>
     <!--//  Welcome message -->
     
     <div id="fields">
          <form method="post" action="dologin.php"  enctype="multipart/form-data">
               <input  type="hidden" name="login" value="login" />
               <table width="333">
                    <?php
	if(isset($_GET['msg'])){
	 ?>
                    <tr>
                         <td colspan="2"  valign="middle"  class="errormsg"><?php  echo $msg; ?></td>
                    </tr>
                    <?php 	
	}
	?>
                    <tr>
                         <td width="79" height="35"><span class="login">Username:</span></td>
                         <td width="244" height="35"><label>
                                   <input name="name" type="text" class="fields" id="name" size="30" />
                                   <!--//  Username field  --> 
                              </label></td>
                    </tr>
                    <tr>
                         <td height="35"><span class="login">Password:</span></td>
                         <td height="35"><input name="password" type="password" class="fields" id="password" size="30" /></td>
                         <!--//  Password field --> 
                    </tr>
                    <?php /*?><tr>
                         <td><span class="login">Security code:</span></td>
                         <td align="left" valign="middle"><img src="common/CaptchaSecurityImages.php?width=191&height=40&character=5" style="border: 1px dotted #808080" /></td>
                    </tr>
                    <tr>
                         <td><span class="login">Verify code:</span></td>
                         <td align="left" valign="middle"><input name="pincode" type="text" class="fields" size="30" id="pincode"  value=""></td>
                    </tr><?php */?>
                    <tr>
                         <td height="65">&nbsp;</td>
                         <td height="65" valign="middle"><label>
                                   <input name="button" type="submit"  class="button" id="button" value="LOGIN" />
                                   &nbsp;&nbsp;&nbsp;&nbsp; <a href="password_support.php">Lost Password?</a> 
                                   
                                   <!--//  login button --> 
                              </label></td>
                    </tr>
               </table>
          </form>
     </div>
</div>
</body>
</html>