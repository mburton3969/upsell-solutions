<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar">
				<li class="navigation-header">
					<span>Navigation</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
<!-------------------------------------------------------------------DASHBOARD-------------------------------------------------------------------------------->
				<?php
			echo '<li>
					<a href="dashboard.php">
						<div class="pull-left"><i class="fas fa-tachometer-alt mr-20"></i><span class="right-nav-text">Dashboard</span></div>';
						
			echo '<div class="clearfix"></div>
					</a>
				  </li>';
				
				?>
        
<!-------------------------------------------------------------------Other Nav Links-------------------------------------------------------------------------------->
				<?php
				
        foreach($nav_links as $nl){
          echo '<li>
              <a href="' . $nl['nav_link_url'] . '">
                <div class="pull-left"><i class="' . $nl['nav_link_icon'] . ' mr-20"></i><span class="right-nav-text">' . $nl['nav_link_title'] . '</span></div>';

          echo '<div class="clearfix"></div>
              </a>
              </li>';
        }
				
				?>

				
<!-------------------------------------------------------------------Make A Suggestion-------------------------------------------------------------------------------->
									<li style="background:#6E6E6E;border:1px solid #222222;">
												<a href="support.php"><i class="fas fa-ticket-alt mr-15"></i> Support Desk</a>
									</li>
				
				
	</ul>
</div>