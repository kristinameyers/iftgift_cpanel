<?php 
include ('../connect/connect.php');
session_start();
if($_SESSION['adminLogin'] == 'True' )	
{	
 header("location:".ruadmin."home.php");
} else{
   session_destroy();
}
if (isset ( $_REQUEST['msg']))  
$msg = base64_decode( $_REQUEST['msg'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<link href="resources/login.css" rel="stylesheet" type="text/css" />
</head>
<title>iftGift Admin Panel</title>
<body>

<div class="box">
	<div class="welcome" id="welcometitle">iftGift, Password Support: </div>

  
  <div id="fields"> 
    <form name="sendpassword" method="post" action="forget_authenticate.php" >
	<input  type="hidden" name="login" value="login" />
      <table width="333">
    <tr>
    
    <td colspan="2" align="left"  valign="middle"  ><span class="login"> Please provide email address below to retrive password</span></td>
  </tr>

      <?php
	if(isset($_GET['msg'])){
	 ?> <tr>
    
    <td colspan="2" align="center"  valign="middle"  class="errormsg"><?php  echo $msg; ?></td>
  </tr>
  <?php 	
	}
	?>
	 <tr>
        <td width="79" height="35"><span class="login">Enter email:</span></td>
        <td width="244" height="35"><label>
          <input name="name" type="text" class="fields" id="name" size="30" />  <!--//  Username field  -->
        </label></td>
      </tr>
 
  <tr>
    <td><span class="login">Security code:</span></td>
    <td align="left" valign="middle">
	 <img src="common/CaptchaSecurityImages.php?width=191&height=40&character=5" style="border: 1px dotted #808080" /></td>
  </tr>
  <tr>
    <td><span class="login">Verify code:</span></td>
    <td align="left" valign="middle"><input name="pincode" type="text" class="fields" size="30" id="pincode"  value=""></td>
  </tr>
  <tr>
	<td height="65">&nbsp;</td>
	<td height="65" valign="middle"><label>
	  <input  type="submit" class="button"  name="sendpassword" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php">Login Page</a>

	  <!--//  login button -->
	</label></td>
  </tr>
</table>
</form>
  </div>
  </div> 
</body>
</html>