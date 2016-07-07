<ul id="main-nav">  <!-- Accordion Menu -->
				<li>
					<a href="<?php  echo $ru ?>admin/home.php" class="nav-top-item <?php  echo $homeclass ?> "> <!-- Add the class "no-submenu" to menu items with no sub menu -->
						Dashboard
					</a>       
				</li>
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=category_manage"   class="nav-top-item  <?php  echo $category_class ?>">Category Management</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=category_manage" <?php echo $category_manage ?>>Category Management</a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=category_add" <?php echo $category_add ?>>Add New Category</a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=category_sub" <?php echo $category_sub ?>>Subcategory Management</a></li>
                        
					</ul>
				</li>
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=product_manage"   class="nav-top-item  <?php  echo $product_class ?>">Product Management</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=product_manage" <?php echo $product_manage,$product_edit ?>>Product Management</a></li>
						<?php /*?><li><a href="<?php echo ruadmin; ?>home.php?p=product_add" <?php echo $product_add ?>>Add New Product</a></li><?php */?>
                        
					</ul>
				</li>
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=ocassion_manage"   class="nav-top-item  <?php  echo $ocassion_class ?>">Ocassion Category/Group Management</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=ocassion_group_manage" <?php echo $ocassion_group_manage ?>>Manage Ocassion Groups</a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=ocassion_manage" <?php echo $ocassion_manage,$ocassion_edit ?>>Manage Ocassion List</a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=ocassion_add" <?php echo $ocassion_add ?>>Add New Ocassion</a></li>
					</ul>
				</li>
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=user_manage"   class="nav-top-item  <?php  echo $user_class ?>">User Management</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=user_manage" <?php echo $user_manage,$user_edit ?>>User Management</a></li>
					</ul>
				</li>
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=importer"   class="nav-top-item  <?php  echo $importer_class ?>">Importer</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=importer" <?php echo $importer; ?>>Importer</a></li>
					</ul>
				</li>
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=user_orders"   class="nav-top-item  <?php  echo $order_class ?>">Order Management</a>                   
					<ul>	
						<li><a href="<?php echo ruadmin; ?>home.php?p=user_orders" <?php echo $user_orders,$view_order;?>>Orders</a></li>              
					</ul>
				</li>
				<li>
					<a href="<?php echo ruadmin; ?>home.php?p=withdraw_cashstash" class="nav-top-item <?php  echo $cashstash ?>">Withdraw Management</a>
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=withdraw_cashstash" <?php echo $withdraw_cashstash ?>>Withdraw</a></li>								
					</ul>
				</li> 
				<li> 
					<a href="<?php echo ruadmin; ?>home.php?p=staff_manage"   class="nav-top-item  <?php  echo $staff_class ?>">Staff Management</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=staff_manage" <?php echo $staff_manage,$member_edit ?>>Staff Members</a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=addnew_member" <?php echo $addnew_member ?>>Add New Staff Member</a></li>
					</ul>
				</li>
				<?php /*?><li>
					<a href="<?php echo ruadmin; ?>home.php?p=emails_alert" class="nav-top-item <?php  echo $emailsalert_class ?>" >Emails 	</a>
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=emails_alert" <?php echo $emails_alert ?>>Email Templates</a></li>	
					</ul>
				</li><?php */?>
				<li>
					<a href="<?php echo ruadmin; ?>home.php?p=payment_setting" class="nav-top-item <?php  echo $settings_class ?>">Settings</a>
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=payment_setting" <?php echo $payment_setting ?>>Payment system</a></li>								
					</ul>
				</li> 
				<?php /*?><li>
					<a  href="<?php echo ruadmin; ?>home.php?p=seo" class="nav-top-item <?php  echo $cmspages_class ?>">Content Management</a>
					<ul>
                              <li><a href="<?php echo ruadmin; ?>home.php?p=aboutus" <?php echo $aboutus ?>>About</a></li>
						
					</ul>
			   </li><?php */?>
               <?php /*?> 
                
                 
                <li> 
					<a href="<?php echo ruadmin; ?>home.php?p=report"   class="nav-top-item  <?php  echo $reporting_module ?>"> Reporting Module</a>                   
					<ul>
						
						 <li><a href="<?php echo ruadmin; ?>home.php?p=report" <?php echo $report ?>>View Orders Reports</a></li>
                         <li><a href="<?php echo ruadmin; ?>home.php?p=report_filter" <?php echo $report_filter ?>>Search in Report</a></li>
                        
					</ul>
				</li>
               <li> 
					<a href="<?php echo ruadmin; ?>home.php?p=banner_manage"   class="nav-top-item  <?php  echo $banner_class ?>">Banner Management</a>                   
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=banner_manage" <?php echo $product_manage ?>>Banner Management</a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=banner_add" <?php echo $product_add ?>>Add New Banner</a></li>
					</ul>
				</li>
                
								
				<li>
					<a href="<?php echo ruadmin; ?>home.php?p=categories" class="nav-top-item <?php  echo $category ?>" >Color / Pattern Options</a>
					<ul>
						<!--<li><a href="<?php //echo ruadmin; ?>home.php?p=categories" <?php //echo $categories ?>>Manage Category</a></li>-->
						
							 <li><a href="<?php echo ruadmin; ?>home.php?p=colors" <?php echo $colors ?>>Manage Color</a></li>	
							 	
                              <li><a href="<?php echo ruadmin; ?>home.php?p=pallet" <?php echo $pallet ?>>Manage Color - Pallet</a></li>	
							  	
                              <li><a href="<?php echo ruadmin; ?>home.php?p=pattrens" <?php echo $pattrens ?>>Manage Patterns</a></li>	

							  <li><a href="<?php echo ruadmin; ?>home.php?p=pattren_pallet" <?php echo $pattren_pallet ?>>Manage Patterns - Pallet</a></li>
		
					</ul>
				</li>


				
				<li>
					<a href="<?php echo ruadmin; ?>home.php?p=templateslist" class="nav-top-item <?php  echo $emailsalert_class ?>" >Emails 	</a>
					<ul>
						<!--<li><a href="<?php echo ruadmin; ?>home.php?p=newslettersmanage" <?php echo $newslettersmanage ?>>Manage Newsletters</a></li>-->
								
						<li><a href="<?php echo ruadmin; ?>home.php?p=contact_emails" <?php echo $contact_emails ?>>Contact Emails </a></li>
						<li><a href="<?php echo ruadmin; ?>home.php?p=emails_alert&type=contact" <?php echo $emails_alert ?>>Email Templates</a></li>	
						<li><a href="<?php echo ruadmin; ?>home.php?p=emails_bulk" <?php echo $emails_bulk ?>>Bulk Emails to User </a></li>
					</ul>
				</li>
						
				
				<li>
					<a href="<?php echo ruadmin; ?>home.php?p=analytics" class="nav-top-item <?php  echo $settings_class ?>">Settings</a>
					<ul>
						<li><a href="<?php echo ruadmin; ?>home.php?p=analytics" <?php echo $analytics ?>>Google Analytics</a></li>								
					</ul>
				</li>  <?php */?>
                <li>
					<a href="<?php echo ruadmin; ?>home.php?p=profilesettings" title="Edit your profile" class="nav-top-item <?php  echo $profilesettings_class ?>">My Profile</a>    
					<ul>
			        	<li><a href="<?php echo ruadmin; ?>home.php?p=profilesettings&userId=<?php echo $_SESSION['cp_cmd']['userId']; ?>"  <?php  echo $profilesettings ?>>Edit my profile</a></li>					
					</ul>					   
				</li>
                 <li>
					<a href="logout.php" class="nav-top-item no-submenu"> Logout</a>       
				</li>
				
			</ul><!-- End #main-nav -->