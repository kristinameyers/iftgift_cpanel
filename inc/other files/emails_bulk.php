<?php //echo '<pre>';print_r($_SESSION);exit;
if ( isset ($_POST['doSearch'] ) ) 
{
	$_SESSION['em_userStatus']=$_POST['userStatus'];
	$_SESSION['em_sText']=trim($_POST['sText']);
	$_SESSION['em_SortBy']=$_POST['SortBy'];
	$_SESSION['em_userType'] = $_POST['userType'];
	$_SESSION['em_sType'] = $_POST['sType'];	
	$_SESSION['em_sState'] = $_POST['sState'];
	$_SESSION['em_sCity'] = $_POST['sCity'];
	
	header("location:".ruadmin."home.php?p=emails_bulk");exit;
}

$qryString =" where 1  ";

if($_SESSION['em_userStatus']=="1")
{
	$qryString .= " and status = '1' ";	
}
elseif($_SESSION['em_userStatus']=="0")
{
	$qryString .= " and status = '0' ";	
}

$innerJoin = '';

if ( $_SESSION['em_sText'] != '' )
{
	$qryString .= " and " . $_SESSION['em_sType'] . " like '%" . $_SESSION['em_sText'] . "%'";
}


	
if ( !isset($_SESSION['em_SortBy']))
{
	$_SESSION['em_SortBy'] = 'Id asc';
}

//-------------------------------------------------------------------------

$t.='
		<table cellpadding="0" cellspacing="0" width="100%">
	
	<tr>
		<td style="bcontact:1px solid #DDDDDD; padding:4px;">
		<form method="post" action="">Status:&nbsp;<select name="userStatus"   onchange="document.getElementById(\'sText\').focus()">			
			<option ';
			if ($_SESSION['em_userStatus'] =='1' )  $t.=' selected="selected" ';
			$t.=' value="1">Read</option>	<option ';
			if ($_SESSION['em_userStatus'] =='0' )  $t.=' selected="selected" ';
			$t.=' value="0">Unread </option>
						
			</select>&nbsp;Search:&nbsp;<select name="sType" id="sType"    onchange="document.getElementById(\'sText\').focus()" >			
			<option ';
			if ($_SESSION['em_sType'] =='name' )  $t.=' selected="selected" ';
			$t.='value="name">User Name</option>
	
			<option ';
			if ($_SESSION['em_sType'] =='email' )  $t.=' selected="selected" ';
			$t.=' value="email">Email</option>						
			</select>
			<input type="text" id="sText"   name="sText" class="text-input" value="'.$_SESSION['em_sText'].'" />';

			$t .= '&nbsp;Sort&nbsp;By:&nbsp;<select name="SortBy"  onchange="document.getElementById(\'sText\').focus()">
			<option  ';			if ($_SESSION['em_SortBy'] =='name asc' )  $t.=' selected="selected" '; 			$t.=' value="name asc">Contact Name Asc</option>
			<option  ';			if ($_SESSION['em_SortBy'] =='name desc' )  $t.=' selected="selected" ';			$t.=' value="name desc">Contact Name Desc</option>
			<option  ';			if ($_SESSION['em_SortBy'] =='email asc' )  $t.=' selected="selected" ';			$t.=' value="email asc">Email Asc</option>
			<option  ';			if ($_SESSION['em_SortBy'] =='email desc' )  $t.=' selected="selected" ';			$t.=' value="email desc">Email Desc</option>			
			</select>
			<br><br> <center><input type="submit" class="button" name="doSearch" id="doSearch" value="Filter Listing" /></center> </form>			
				
		</td>
	</tr>	
	<tr>
		<td> '.$SearchMsg.'</td>
	</tr></table>';
	$sortyby = ' group by Id contact by '.$_SESSION['em_SortBy'];
	$sql_sel_user = "SELECT * FROM `contact` ";  
	
	//echo $sortyby;exit;
	$query_sel_user = mysql_query($sql_sel_user) or die(mysql_error());
	
	$qry = "select * from  emails where type = 'bulkemail'";

	$rs=mysql_query($qry);
	$row =mysql_fetch_array($rs);
	 
	$subject=$row['subject'];
	$htmlData=$row['body'];
	$type =$row['type'];
	$mailfrom = $row['touser'];
	$htmlData = $htmlData;
	unset($_SESSION['em_userStatus']);
	unset($_SESSION['em_sText']);
	unset($_SESSION['em_SortBy']);
	unset($_SESSION['userType']);	
?>
<h3><a href="#">Home</a> &raquo; <a href="#" class="active">Bulk Email</a></h3>
<div class="content-box">
	<div class="content-box-header">
		<h3>Bulk Email to Users </h3>
		<div class="clear"></div>
	</div>
	<div class="content-box-content">
	<?php echo $t;  ?>
  <?php if ( isset ($_GET['s'] ) ) {?>
		<div class="notification error png_bg" >
			<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
			<div>
				<?php if($_GET['s']=='1') echo "Email sent successfully!"; else echo "Email not sent. Please select to addresses"; ?>
			</div>
		</div>	
  <?php } ?>	
	<form   method="post" action="process/process_bluckemail.php">
	<table width="100%" bcontact="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><strong>To:</strong></td>
	  </tr>	  
	  <tr>
		<td>
		<?php if(mysql_num_rows($query_sel_user)>0){?>
		  <select name="slect_all[]" size="10" multiple="multiple" id="slect_all[]">
		  <?php while($row_user = mysql_fetch_array($query_sel_user)) {?>
			<option value="<?php echo $row_user['name'].$row_user['email'];?>"><?php echo $row_user['fname']." (".$row_user['email'].")";?></option>
		  <?php }?>
		  </select>
		  <br/><a href="javascript:void(0);" onclick="allSelected();">Select all </a>&nbsp;/<a href="javascript:void(0);" onclick="deSelected();"> Deselect </a>
		</td>
	  </tr>
	  <tr>
		<td><strong>Email From:</strong></td>
	  </tr>
	  <tr>
	  		<td><input type="hidden" name="savepage" value="<?php echo $type; ?>">
			<input type="hidden" name="mailto" value="<?php echo $email_row['touser'];?>" />
			<input type="text" name="mailfrom" value="<?php echo $mailfrom; ?>" size="93" class="text-input">
			</td>
		</tr>	
		<tr>
			<td><strong>Email&nbsp;Subject:</strong></td>
		</tr>
		<tr>
			<td><input type="text" name="txtSubject" value="<?php echo $subject; ?>" size="93" class="text-input"></td>
		</tr>			
		<tr>
			<td  valign="top"><strong>Email&nbsp;Body:</strong></td>
		</tr>
		<tr>
			<td>User Keyword {{FirstName}}, {{LastName}} <br/>
			<?php		
				include("FCKeditor/fckeditor.php");		
				$oFCKeditor = new FCKeditor('txtData') ;
				$oFCKeditor->BasePath = 'FCKeditor/';
				$oFCKeditor->Value = nl2br($htmlData);
				$oFCKeditor->Create() ;
		?></td>
		</tr>
		<tr>
			<td>
			<input type="submit" class="button" name="SaveTextData" value="Send Email" /></td>
		</tr>
	</table>
	<?php } else {echo "No user fond";}?>
	</form>
	</div>
</div>	
<script language="javascript" type="text/javascript">
function getSelected()
{
	ob=document.getElementById("idmare_category[]");
	nlength=ob.length;
	tmp='';
	for ( i=0; i<nlength; i++ ) 
	{
		if (ob.options[i].selected == true) 
		{
			if (tmp == '' )
			{
				tmp= ob.options[i].value;
			}
			else
			{
				tmp=tmp + ',' + ob.options[i].value;
			}
		}
	}
	alert (tmp);
}

function allSelected()
{
	ob=document.getElementById("slect_all[]");
	nlength=ob.length;
	for ( i=0; i<nlength; i++ ) 
	{
		ob.options[i].selected = true;
	}
}
allSelected();
function deSelected()
{
	ob=document.getElementById("slect_all[]");
	nlength=ob.length;
	for ( i=0; i<nlength; i++ ) 
	{
		ob.options[i].selected = false;
	}
}
</script>