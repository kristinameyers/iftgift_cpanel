<?php 
if ( isset ($_POST['save'] )) {

		
		$msgAdd = '';
		$seoTitle1 =addslashes( $_POST['txtTitle']);
		$seoKeywords1 =addslashes( $_POST['txtKeywords']);
		$seoDescription1 =addslashes( $_POST['txtDescription']);
		$seoPage1 =addslashes( $_POST['txtPage']);
		
		if  ($seoPage1 == '') $msgAdd.='  Page name missing. '; 
		if  ($seoTitle1 == '') $msgAdd.='  title missing. '; 
		if  ($seoKeywords1 == '') $msgAdd.='  Keywords missing. '; 
		if  ($seoDescription1 == '') $msgAdd.='  Description missing. ';
		 
		 
		 if  ( $msgAdd == '' ) 
		 {
		 	
			  $qry = " insert into   seo  set Title = '".$seoTitle1."'
			  								,Keywords= '".$seoKeywords1."'
											, description  = '".$seoDescription1."'
											
											,page= '".$seoPage1."'
											
											" ;
			  @mysql_query($qry);
			  $_SESSION['SEOSAVED']= 'SEO for $seoPage  Updated';
			  header("location:home.php?p=seo");exit;
		}			 
}
if ( isset ($_POST['update'] )) {
		$msg2 = '';
		$seoTitle =addslashes( $_POST['txtTitle']);
		$seoKeywords =addslashes( $_POST['txtKeywords']);
		$seoDescription =addslashes( $_POST['txtDescription']);
		$seoPage =addslashes( $_POST['txtPage']);
		
		if  ($seoPage == '') $msg2.='  Page name missing. '; 
		if  ($seoTitle == '') $msg2.='  title missing. '; 
		if  ($seoKeywords == '') $msg2.='  Keywords missing. '; 
		if  ($seoDescription == '') $msg2.='  Description missing. '; 
		if  ( $msg2 == '' ) 
		 {
		 	
			  $qry = " update  seo  set Title = '".$seoTitle."'
			  								,Keywords= '".$seoKeywords."'
											, description  = '".$seoDescription."'
											,page= '".$seoPage."'
			  								
										where Id=".$_POST['updateId'] ;
			
			  @mysql_query($qry);
			  $_SESSION['SEOSAVED']= 'SEO for $seoPage  Updated';
			  header("location:home.php?p=seo");exit;
		  
		}else{
			$seoId=$_POST['updateId'];
		}
			 
			 

}
if ( isset ($_POST['action'] )) {
	
	$seoId=$_POST['seoId'];

	if ( $_POST['action'] == 'edit')
	{
				$qry="select Title, Keywords, description, page  from `seo` where Id=".$seoId;

				$rs=@mysql_query($qry);
				$row = @mysql_fetch_array($rs);
				$seoTitle =$row[0];
				$seoKeywords =$row[1];
				$seoDescription =$row[2];
				$seoPage =$row[3];
				$web_contents =$row[4];
		
	}	
	if ( $_POST['action'] == 'delete')
	{
			$qry="delete from `seo` where Id=".$seoId;
			$rs=@mysql_query($qry);
		  $_SESSION['SEOSAVED']= 'SEO Entry Deleted!';
	}
	
	
}
 $mSize = 80;
?>
<div class="content-box">
        		
               <div class="content-box-header">
					<h3>SEO Management</h3>
					<div class="clear"></div>
				</div>
                <div class="content-box-content">
    			<?php if ( isset($_SESSION['SiteMapSaved']) ) { ?>
                   <div class="notification error png_bg">
                    <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                    <div>
                         <?php 
                            echo $_SESSION['SiteMapSaved'];                           unset($_SESSION['SiteMapSaved']);
                        ?>
                    </div>
                </div>
            
				<?php }  ?>            
<table width="100%">
			<tr  class="rowtitle">

				<td width="25%" class="titletd"><strong>Page Name</strong></td>
				<td width="20%" class="titletd"><strong>Title Tag</strong></td>
				<td width="25%" class="titletd"><strong>Meta Keywords</strong></td>
				<td width="21%" class="titletd"><strong>Meta Description</strong></td>
				<td width="9%" class="titletd"><strong>Action</strong></td>				
			</tr>

			
			<?php
				
				$qry="select Id, page,Title ,Keywords,description from `seo` order by Id";
				$rs=mysql_query($qry) or die ("asfasd as");
				$count=0;
				
				$bg= "#F6F6F6";
				while ($row = @mysql_fetch_array($rs))
				{
				
					$count++;
					
					$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';
				
					?><tr <?php echo $bgcolor;?>>
									
									<td class="texttd"> <?php echo  $row['page'] ?></td>
									<td class="texttd"> <?php echo  $row['Title'] ?></td>
									<td class="texttd"> <?php echo  $row['Keywords'] ?></td>
									<td class="texttd"> <?php echo  $row['description'] ?></td>									
									<td align="center" class="texttd">
									<img src="resources/images/icons/pencil.png" height="18" width="18" style="border:none;cursor:pointer;padding-left:5px;padding-right:5px" onClick="editSEO(<?php echo $row['Id'] ?>)" 	title="Modify " />&nbsp;&nbsp;
									<img src="resources/images/icons/cross.png" height="18" width="18" style="border:none;cursor:pointer;padding-left:5px;padding-right:5px" onClick="DeleteSEO(<?php echo $row['Id'] ?>)" 	title="Delete " />

									</td>	
								</tr>

				<?php if ($seoId ==  $row['Id'])
				{	?>	
		<tr><td colspan="5"> 
	
    <form   method="post"  name="frmSEO"  action="home.php?p=seo" >
    <fieldset>	
	<input type="hidden" name="updateId" id="updateId" value="<?php echo $seoId ?>">
			
	<?php if ( isset($msg2) ) { ?>
               <div class="notification attention png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					 <?php echo $msg2 ?>
				</div>
			</div>
            
				<?php }  ?>		
	
	<p>		
	<label>Page Name:</label>   <input type="text" name="txtPage" id="txtPage" value="<?php echo $seoPage  ?>"  class="text-input medium-input"  > 
    </p><p>
	<label>Title Tag:</label>   <input type="text" name="txtTitle" id="txtTitle" value="<?php echo $seoTitle  ?>"  class="text-input large-input"  >
    </p><p>
	<label>Meta Keywords:</label>   <input type="text" name="txtKeywords" id="txtKeywords" value="<?php echo $seoKeywords  ?>"  class="text-input large-input"  >
    </p><p>
    <label>Meta Description:</label>   <input type="text" name="txtDescription" id="txtDescription" value="<?php echo $seoDescription  ?>"  class="text-input large-input"  >
    </p>
	
	<p>

    <input type="submit" name="SaveTextData" class="button" value="&nbsp;&nbsp;&nbsp;&nbsp; Save Page &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">	
</p>
	<input type="hidden" value="Update" name="update" class="b" >
		
	</fieldset>
	</form>
				</td>
			</tr>			
				<?php 


	
			}
				} ?>
	
	</table>
</div></div>
<div class="content-box">
        		
               <div class="content-box-header">
					<h3>Add More SEO Pages</h3>
					<div class="clear"></div>
				</div>
                <div class="content-box-content" >

 <form   method="post"  name="frmSEO"  action="home.php?p=seo" >
    <fieldset>	
	<input type="hidden" name="updateId" id="updateId" value="<?php echo $seoId ?>">
			
	<?php if ( isset($msgAdd) ) { ?>
               <div class="notification attention png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					 <?php echo $msgAdd ?>
				</div>
			</div>
            
				<?php }  ?>		
	
	<p>		
	<label>Page Name:</label>   <input type="text" name="txtPage" id="txtPage" value="<?php echo $seoPage1  ?>"  class="text-input medium-input"  > 
    </p><p>
	<label>Title Tag:</label>   <input type="text" name="txtTitle" id="txtTitle" value="<?php echo $seoTitle1  ?>"  class="text-input large-input"  >
    </p><p>
	<label>Meta Keywords:</label>   <input type="text" name="txtKeywords" id="txtKeywords" value="<?php echo $seoKeywords1  ?>"  class="text-input large-input"  >
    </p><p>
    <label>Meta Description:</label>   <input type="text" name="txtDescription" id="txtDescription" value="<?php echo $seoDescription1  ?>"  class="text-input large-input"  >
    </p>
	
		
	
	<p>

    <input type="submit" name="SaveTextData" class="button" value="&nbsp;&nbsp;&nbsp;&nbsp; Save Page &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">	
</p>
	<input type="hidden" value="Save" name="save" class="b" >
		<strong>Note:</strong> http://piecesbyfarah.com/<strong>aboutus</strong> , to set seo options , page name must be starting after "http://piecesbyfarah.com/" and ends  "/aboutus" in above example "<strong>aboutus</strong>" is page name </td>
	</fieldset>
	</form>
    

<span style="display:none;">
<script language="javascript" type="text/javascript">
	function editSEO(cid){
		document.getElementById('seoId').value=cid;
		document.getElementById('action').value="edit";
		document.getElementById('frmAction').submit();
	}
	function DeleteSEO(cid){
		var tmp=confirm ('this will delete SEO for page Link from list!. Are you sure ?'); 
		if (tmp){ 
			document.getElementById('seoId').value=cid;
			document.getElementById('action').value="delete";
			document.getElementById('frmAction').submit();
		}

	}

</script>

<form method="post" name="frmAction" id="frmAction" action="home.php?p=seo" >
	<input type="hidden" id="action" name="action" value="" >
	<input type="hidden" id="seoId" name="seoId" value="" >									
</form>
</span> <?php unset ($_SESSION['SiteMapSaved']); ?>


<br><br>
                
                <!-- // #main -->
                
                <div class="clear"></div>
            </div>
            <!-- // #container -->
        </div>	
        <!-- // #containerHolder -->