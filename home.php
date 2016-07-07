<?php 
ob_start();
require_once("../connect/connect.php");
include ("../config/config.php");	
include ('security.php');
if ( isset ($_GET['p']) )
{
	$content =  $_GET['p'].".php";
	if (!file_exists('inc/'.$content))	
	{
		$content =  'dashboard.php';
		$_GET['p'] ='';
	}
}
else
{
	$content =  'dashboard.php';
}

if ( isset (  $_SESSION['sfilter']  )  &&  ( $content != 'report_filter.php' && $content != 'download_report.php'))
{
unset ( $_SESSION['sfilter']);	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>iftGift Admin Panel</title>
<link rel="shortcut icon" href="<?php echo $ru ?>favicon.ico"/>
<link rel="icon" href="<?php echo $ru ?>favicon.ico" />
<!--                       CSS                       -->
<!-- Reset Stylesheet -->
<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo ru_css ?>admin.css" type="text/css" media="screen" />

<!-- Main Stylesheet -->
<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />

<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
<link rel="stylesheet" href="resources/css/blue.css" type="text/css" media="screen" />  
<style>
.box_bg{
width:18px; height:15px; border-bottom:2px solid #FFFFFF; border-right:2px solid #ffffff; float:left;
}
</style>
<!-- Internet Explorer Fixes Stylesheet -->
<!--[if lte IE 7]>
	<link rel="stylesheet" href="resources/css/ie.css" type="text/css" media="screen" />
<![endif]-->
<!-- Javascripts -->

<!-- jQuery -->
<script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>

<!-- jQuery Configuration -->
<script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>

<!-- Facebox jQuery Plugin -->
<script type="text/javascript" src="resources/scripts/facebox.js"></script>

<!-- jQuery WYSIWYG Plugin -->
<script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
<?php if($_GET['p'] == 'ocassion_add' || $_GET['p'] == 'ocassion_edit') { ?>
<link rel="stylesheet" type="text/css" href="resources/scripts/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="resources/scripts/jquery.multiselect.js"></script>
<?php } ?>
<?php /*?><script type="text/javascript" src="<?php  echo ru; ?>js/functions.js"></script><?php */?>

<!-- Internet Explorer .png-fix -->

<!--[if IE 6]>
	<script type="text/javascript" src="resources/scripts/DD_belatedPNG_0.0.7a.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('.png_bg, img, li');
	</script>
<![endif]-->

<?php /*?><script type="text/javascript" src="../js/ajax.js"></script><?php */?>
<?php 
if ( in_array( $_GET['p'], array( 'category_manage','category_add','category_sub') ) ){
	$category_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'user_manage','user_edit') ) ){
	$user_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'product_manage','product_edit','product_export', 'businessowners' ,'product_add','product_reviews') ) ){
	$product_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'ocassion_manage','ocassion_add','ocassion_group_manage','ocassion_edit') ) ){
	$ocassion_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'importer') ) ){
	$importer_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'user_orders','view_order') ) ){
	$order_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'staff_manage' ,'addnew_member','member_edit') ) ){
	$staff_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'banner_manage' ,'banner_add','banner_edit') ) ){
	$banner_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'report','report_filter','xxxx','xxx','xxx','xxx') ) ){
	$reporting_module = ' current ';
}




if ( in_array( $_GET['p'], array( 'aboutus','contact','seo','creator','cms_images') ) ){
	$cmspages_class = ' current ';
}


if ( in_array( $_GET['p'], array( 'categories','colors','pattrens', 'pallet', 'pattren_pallet') ) ){
	$category = ' current ';
}




if ( in_array( $_GET['p'], array( 'contact_emails','templateslist','newslettersmanage','emails_alert' ,'emails_bulk','newsletter','read_contact' ) ) ){
	$emailsalert_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'payment_setting') ) ){
	$settings_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'withdraw_cashstash') ) ){
	$cashstash = ' current ';
}



if ( in_array( $_GET['p'], array( 'product_edit') ) ){
	$editprofile_class = ' current ';
}

if ( in_array( $_GET['p'], array( 'profilesettings'  ) ) ){
		    $profilesettings_class = ' current ';
}

$$_GET['p'] = ' class="current" ';	

if (!isset($_GET['p'])){
    $homeclass = ' current ';
}
?>
</head>
<body>
<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<div id="sidebar">
		<div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			
			<h1 id="sidebar-title">Admin Panel  </h1>
		  
			<!-- Logo (221px wide) -->
               <a href="home.php" style="margin-left:30px; " ><img id="logo" src="images/logo.jpg" alt="Admin Panel Pieces By Farah" style="text-align:center; background:transparent;" /></a>
			<!-- Sidebar Profile links -->
			<div id="profile-links">
            
				Hello,<?php echo $_SESSION['cp_cmd']['firstname']; ?>,Logged in as <?php if($_SESSION['cp_cmd']['type'] == 'a') { ?>Admin<?php } else { ?>Staff<?php } ?>
                
				<br />
				<a href="<?php echo ru; ?>" title="View the Site" target="_blank">View the Site</a> | <a href="logout.php" title="Sign Out">Sign Out</a>
			</div>   
			<?php if($_SESSION['cp_cmd']['type'] == 'a') { 
				include_once('admin_home.php');
			 } else { ?>  
			 <ul id="main-nav">  <!-- Accordion Menu -->
				<li>
					<a href="<?php  echo $ru ?>admin/home.php" class="nav-top-item <?php  echo $homeclass ?> "> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						Dashboard
					</a>       
				</li>
				<?php
					$get_pre = mysql_query("select privilege from ".tbl_user." where userid = '".$_SESSION['cp_cmd']['userId']."'");
					if(mysql_num_rows($get_pre) > 0) {
						$result = mysql_fetch_array($get_pre);
						$privilege = explode(',',$result['privilege']);
						foreach($privilege as $pre) {
						if($pre == 1) {
						?>
						<li> 
							<a href="<?php echo ruadmin; ?>home.php?p=category_manage"   class="nav-top-item  <?php  echo $category_class ?>">Category Management</a>
							<ul>
								<li><a href="<?php echo ruadmin; ?>home.php?p=category_manage" <?php echo $category_manage ?>>Category Management</a></li>
								<li><a href="<?php echo ruadmin; ?>home.php?p=category_add" <?php echo $category_add ?>>Add New Category</a></li>
								<li><a href="<?php echo ruadmin; ?>home.php?p=category_sub" <?php echo $category_sub ?>>Subcategory Management</a></li>
							</ul>
						</li>
						<?php	} if($pre == 2) { ?>
						<li> 
							<a href="<?php echo ruadmin; ?>home.php?p=product_manage"   class="nav-top-item  <?php  echo $product_class ?>">Product Management</a>
							<ul>
								<li><a href="<?php echo ruadmin; ?>home.php?p=product_manage" <?php echo $product_manage,$product_edit ?>>Product Management</a></li>
							</ul>
						</li>
						<?php	} if($pre == 3) { ?>
						<li> 
							<a href="<?php echo ruadmin; ?>home.php?p=ocassion_manage"   class="nav-top-item  <?php  echo $ocassion_class ?>">Ocassion Category/Group Management</a>                   
							<ul>
								<li><a href="<?php echo ruadmin; ?>home.php?p=ocassion_group_manage" <?php echo $ocassion_group_manage ?>>Manage Ocassion Groups</a></li>
								<li><a href="<?php echo ruadmin; ?>home.php?p=ocassion_manage" <?php echo $ocassion_manage,$ocassion_edit ?>>Manage Ocassion List</a></li>
								<li><a href="<?php echo ruadmin; ?>home.php?p=ocassion_add" <?php echo $ocassion_add ?>>Add New Ocassion</a></li>
							</ul>
						</li>
						<?php	} if($pre == 4) { ?>
						<li> 
							<a href="<?php echo ruadmin; ?>home.php?p=importer"   class="nav-top-item  <?php  echo $importer_class ?>">Importer</a>                   
							<ul>
								<li><a href="<?php echo ruadmin; ?>home.php?p=importer" <?php echo $importer; ?>>Importer</a></li>
							</ul>
						</li>
						<?php	} if($pre == 5) { ?>
						<li> 
							<a href="<?php echo ruadmin; ?>home.php?p=user_orders"   class="nav-top-item  <?php  echo $order_class ?>">Order Management</a> 
							<ul>	
								<li><a href="<?php echo ruadmin; ?>home.php?p=user_orders" <?php echo $user_orders,$view_order;?>>Orders</a></li>              
							</ul>
						</li>
						<?php	} if($pre == 6) { ?>
						<li>
							<a href="<?php echo ruadmin; ?>home.php?p=withdraw_cashstash" class="nav-top-item <?php  echo $cashstash ?>">Withdraw Management</a>
							<ul>
								<li><a href="<?php echo ruadmin; ?>home.php?p=withdraw_cashstash" <?php echo $withdraw_cashstash ?>>Withdraw</a></li>								
							</ul>
						</li> 
						<?php 
							}
						}
					}
				?>
                <li>
					<a href="<?php echo ruadmin; ?>home.php?p=profilesettings" title="Edit your profile" class="nav-top-item <?php  echo $profilesettings_class ?>">My Profile</a>    
					<ul>
			        	<li><a href="<?php echo ruadmin; ?>home.php?p=profilesettings&userId=<?php echo $_SESSION['cp_cmd']['userId']; ?>"  <?php  echo $profilesettings ?>>Edit my profile</a></li>					
					</ul>					   
				</li>
                 <li>
					<a href="logout.php" class="nav-top-item no-submenu"> Logout</a>       
				</li>
				
			</ul>  
			 <?php } ?>
		</div>
		</div> <!-- End #sidebar -->
        <div id="main-content-top">
           <ul class="shortcut-buttons-set">
                    
                    <li><a class="shortcut-button new-article" href="home.php"><span class="png_bg">
                        Stats
                    </span></a></li>
                    
                    <!--<li><a class="shortcut-button new-page" href="<?php echo ruadmin; ?>home.php?p=business"><span class="png_bg">
                        Lender
                    </span></a></li>-->
                    <?php if($_SESSION['cp_cmd']['type'] == 'a') { ?>
                    <li><a class="shortcut-button upload-image" href="<?php echo ruadmin; ?>home.php?p=product_manage"><span class="png_bg">
                        Products
                    </span></a></li>
					<?php } ?>
					<?php
					//$orderQry = mysql_query("SELECT * FROM orders where fname !='' and status = '0'");
					//$orderNum = mysql_num_rows($orderQry);
					?>
					<?php /*?><li><a class="shortcut-button orders-image" href="<?php echo ruadmin; ?>home.php?p=user_orders&status=0"><span class="png_bg">
                        New Orders (<?php echo $orderNum; ?>)
                    </span></a></li>
                    
                    <li><a class="shortcut-button add-event" href="<?php echo ruadmin; ?>home.php?p=emails_alert"><span class="png_bg">
                        Templates
                    </span></a></li><?php */?>
                    
                    <li><a class="shortcut-button manage-comments" href="<?php echo ruadmin; ?>home.php?p=profilesettings&userId=<?php echo $_SESSION['cp_cmd']['userId']; ?>"><span class="png_bg">
                        My Profile
                    </span></a></li>
                    
                </ul>
        </div>
                
		<div id="main-content"> <!-- Main Content Section with everything -->
            <noscript> <!-- Show a notification if the product has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<!-- End .shortcut-buttons-set -->
			
			<div class="clear"></div> <!-- End .clear -->

        	<?php  include('inc/'.$content); ?>
		    <!-- // #wrapper -->
   
			<div id="footer">
				<small>
						&#169; Copyright <?php echo date('Y');?> Pieces By Farah   | <a href="#">Top</a>
				</small>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->

	</div>
</body>
</html><?php ob_end_flush(); ?>