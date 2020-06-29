		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="index.php">
							<?php
              	echo '<img class="brand-img" alt="brand" src="http://' . $_SERVER['HTTP_HOST'] . '/global/imgs/reseller-logo.png" style="width:60%;top:-15px;left:15px;">';
              ?>
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
				<form id="search_form" role="search" class="top-nav-search collapse pull-left">
					<div class="input-group">
						<input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
						<span class="input-group-btn">
						<button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
						</span>
					</div>
				</form>
			</div>
      <?php
      include 'global/php/connection.php';
      //Get Activity...
      $ulq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . $_SESSION['user_id'] . "' AND `log_type` = 'UPC Scan' AND `date` = CURRENT_DATE AND `user_id` = '" . $_SESSION['user_id'] . "'";
      $ulg = mysqli_query($conn, $ulq) or die($conn->error);
      $slq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . $_SESSION['user_id'] . "' AND `log_type` = 'Listing_Store' AND `date` = CURRENT_DATE AND `listed` = 'Yes' AND `user_id` = '" . $_SESSION['user_id'] . "'";
      $slg = mysqli_query($conn, $slq) or die($conn->error);
      $elq = "SELECT * FROM `upc_search_log` WHERE `user_id` = '" . $_SESSION['user_id'] . "' AND `log_type` = 'Listing_Ebay' AND `date` = CURRENT_DATE AND `listed` = 'Yes' AND `user_id` = '" . $_SESSION['user_id'] . "'";
      $elg = mysqli_query($conn, $elq) or die($conn->error);
      $ilq = "SELECT * FROM `ebay_imports` WHERE `user_id` = '" . $_SESSION['user_id'] . "' AND `status` = 'Imported' AND `date` = CURRENT_DATE AND `user_id` = '" . $_SESSION['user_id'] . "'";
      $ilg = mysqli_query($conn, $ilq) or die($conn->error);
      //Counts...
      $upc_count = mysqli_num_rows($ulg);
      $store_count = mysqli_num_rows($slg);
      $ebay_count = mysqli_num_rows($elg);
      $import_count = mysqli_num_rows($ilg);
      $total_store_count = $store_count - $import_count;
      $total_ebay_count = $ebay_count - $import_count;
      ?>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
          <li class="text-center mr-20">
            <button type="button" class="btn btn-success btn-sm mt-15" style="padding:5px;" onclick="get_api_usage();">
              <i class="fa fa-refresh"></i>
            </button>
          </li>
          <li class="text-center mr-20">
            <p>
              API Calls<br><span id="api_calls"></span>
            </p>
          </li>
          <li class="text-center mr-20">
            <p>
              UPC Scans<br> <?php echo $upc_count; ?>
            </p>
          </li>
          <li class="text-center mr-20">
            <p>
              81O Listings<br> <?php echo $total_store_count; ?>
            </p>
          </li>
          <li class="text-center mr-20">
            <p>
              Ebay Listings<br> <?php echo $total_ebay_count; ?>
            </p>
          </li>
          <li class="text-center mr-20">
            <p>
              Ebay Imports<br> <?php echo $import_count; ?>
            </p>
          </li>
					<li>
						<a id="open_right_sidebar" href="#"><i class="fas fa-comments top-nav-icon"></i><span class="top-nav-icon-badge" id="chat-badge" style="display:none;">!</span></a>
					</li>
					<!--<li class="dropdown alert-drp">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications top-nav-icon"></i><span class="top-nav-icon-badge">5</span></a>
						<ul  class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
							<li>
								<div class="notification-box-head-wrap">
									<span class="notification-box-head pull-left inline-block">notifications</span>
									<a class="txt-danger pull-right clear-notifications inline-block" href="javascript:void(0)"> clear all </a>
									<div class="clearfix"></div>
									<hr class="light-grey-hr ma-0"/>
								</div>
							</li>
							<li>
								<div class="streamline message-nicescroll-bar">
									<div class="sl-item">
										<a href="javascript:void(0)">
											<div class="icon bg-green">
												<i class="zmdi zmdi-flag"></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">
												New subscription created</span>
												<span class="inline-block font-11  pull-right notifications-time">2pm</span>
												<div class="clearfix"></div>
												<p class="truncate">Your customer subscribed for the basic plan. The customer will pay $25 per month.</p>
											</div>
										</a>	
									</div>
									<hr class="light-grey-hr ma-0"/>
									<div class="sl-item">
										<a href="javascript:void(0)">
											<div class="icon bg-yellow">
												<i class="zmdi zmdi-trending-down"></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications txt-warning">Server #2 not responding</span>
												<span class="inline-block font-11 pull-right notifications-time">1pm</span>
												<div class="clearfix"></div>
												<p class="truncate">Some technical error occurred needs to be resolved.</p>
											</div>
										</a>	
									</div>
									<hr class="light-grey-hr ma-0"/>
									<div class="sl-item">
										<a href="javascript:void(0)">
											<div class="icon bg-blue">
												<i class="zmdi zmdi-email"></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">2 new messages</span>
												<span class="inline-block font-11  pull-right notifications-time">4pm</span>
												<div class="clearfix"></div>
												<p class="truncate"> The last payment for your G Suite Basic subscription failed.</p>
											</div>
										</a>	
									</div>
									<hr class="light-grey-hr ma-0"/>
									<div class="sl-item">
										<a href="javascript:void(0)">
											<div class="sl-avatar">
												<img class="img-responsive" src="dist/img/avatar.jpg" alt="avatar"/>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">Sandy Doe</span>
												<span class="inline-block font-11  pull-right notifications-time">1pm</span>
												<div class="clearfix"></div>
												<p class="truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
											</div>
										</a>	
									</div>
									<hr class="light-grey-hr ma-0"/>
									<div class="sl-item">
										<a href="javascript:void(0)">
											<div class="icon bg-red">
												<i class="zmdi zmdi-storage"></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications txt-danger">99% server space occupied.</span>
												<span class="inline-block font-11  pull-right notifications-time">1pm</span>
												<div class="clearfix"></div>
												<p class="truncate">consectetur, adipisci velit.</p>
											</div>
										</a>	
									</div>
								</div>
							</li>
							<li>
								<div class="notification-box-bottom-wrap">
									<hr class="light-grey-hr ma-0"/>
									<a class="block text-center read-all" href="javascript:void(0)"> read all </a>
									<div class="clearfix"></div>
								</div>
							</li>
						</ul>
					</li>-->
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
							<i class="zmdi zmdi-account zmdi-hc-lg"></i><span> <?php echo $_SESSION['user_name']; ?></span>
							<i class="zmdi zmdi-caret-down"></i>
							<!--<img src="dist/img/user1.png" alt="user_auth" class="user-auth-img img-circle"/>-->
							<!--<span class="user-online-status"></span>-->
						</a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<!--<li>
								<a href="access.php"><i class="zmdi zmdi-accounts"></i><span>Manage Users</span></a>
							</li>
							<li>
								<a href="settings.php"><i class="zmdi zmdi-settings"></i><span>My Account</span></a>
							</li>
							<li>
                <a href="knowledge-base.php"><i class="zmdi zmdi-graduation-cap"></i><span>Knowledge Base</span></a>
              </li>
							<li>
								<a href="../cron/labels.php" target="_blank"><i class="zmdi zmdi-labels"></i><span>Print Labels</span></a>
							</li>-->
							<!--<li class="divider"></li>
							<li class="sub-menu show-on-hover">
								<a href="#" class="dropdown-toggle pr-0 level-2-drp"><i class="zmdi zmdi-check text-success"></i> available</a>
								<ul class="dropdown-menu open-left-side">
									<li>
										<a href="#"><i class="zmdi zmdi-check text-success"></i><span>available</span></a>
									</li>
									<li>
										<a href="#"><i class="zmdi zmdi-circle-o text-warning"></i><span>busy</span></a>
									</li>
									<li>
										<a href="#"><i class="zmdi zmdi-minus-circle-outline text-danger"></i><span>offline</span></a>
									</li>
								</ul>	
							</li>-->
							<li class="divider"></li>
							<li>
								<a href="../login.php?logout=yes"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>
		<!-- /Top Menu Items -->
		
		<!-- Left Sidebar Menu -->
		<?php include 'global/sections/left-sidebar.php'; ?>
		<!-- /Left Sidebar Menu -->
		
		<!-- Right Sidebar Menu -->
		<?php include 'global/sections/right-sidebar.php'; ?>
		<!-- /Right Sidebar Menu -->