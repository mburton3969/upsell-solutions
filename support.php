<?php
session_start();
include 'security/check-login.php';
$pageName = 'Support';
$pageIcon = 'fas fa-file';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $pageName; ?> | Reseller Solutions</title>
    <?php include 'global/sections/head.php'; ?>
  <style>
    blockquote{
      color: #6e6e6e !important;
    }
  </style>
</head>

<body>
	<!-- Preloader -->
	<?php include 'global/sections/preloader.php'; ?>
	<!-- /Preloader -->
    <div class="wrapper theme-4-active pimary-color-red">

    	<!--Navigation-->
    	<?php include 'global/sections/nav.php'; ?>
		
		
        <!-- Main Content -->
		<div class="page-wrapper"><!--Includes Footer-->

      <div class="container-fluid pt-25"><!--Main Content Here-->
				<?php include 'global/sections/page-title-bar.php'; ?>

        <?php include 'support/sections/tickets-display.php'; ?>
        
			</div>
			
			
			<!-- Footer -->
			<?php include 'global/sections/footer.php'; ?>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
  
  <!-- Modals -->
  <?php include 'support/modals/view-ticket-modal.php'; ?>
	
	<!--Footer-->
	<?php include 'global/sections/includes.php'; ?>
  <script src="support/js/jira-ticket-functions.js?cb=<?php echo $cache_buster; ?>"></script>
</body>

</html>
