<?php 
if ( isset($_GET['Id']) and $_GET['Id'] != '')
{ 

	mysql_query("update contact set status = '1' where Id = '".$_GET['Id'] ."'");
	
	$contact_sql  = mysql_query("select * from contact where Id = '".$_GET['Id'] ."'");
	$rowContact   = mysql_fetch_array($contact_sql);
	
}
?>

<div class="content-box">
	<div class="content-box-header">

		<h3>User Contact Detail</h3>

		<div class="clear"></div>
	</div>
	<div class="content-box-content">                    

   <div id="main">
                
                	<form  method="post" action="#">

                    	<fieldset>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Contact Name:</label>&nbsp;&nbsp;<?php echo $rowContact['name']; ?></p>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Contact Email:</label>&nbsp;&nbsp;<?php echo $rowContact['email']; ?></p>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Mobile Number:</label>&nbsp;&nbsp;<?php echo $rowContact['phone']; ?></p>
							<p><label style="background-color:#f1f1f1; padding:7px 0px 7px 10px; margin-bottom:12px;">Message Detail:</label>&nbsp;&nbsp;<?php echo $rowContact['message']; ?></p>
						
              			 </fieldset>
                    </form>
                </div>
            </div>
        </div>	     
