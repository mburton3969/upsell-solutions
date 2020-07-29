<?php
session_start();
include 'security/check-login.php';
$pageName = 'Quick Print';
$pageIcon = 'fas fa-print';

include 'assets/php/connection.php';

//Include Label Templates...
//include 'assets/dymo/label-templates/hang-tag-1.php';
//include 'assets/dymo/label-templates/hang-tag-2.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $pageName; ?> | Reseller Solutions</title>
    <?php include 'global/sections/head.php'; ?>
  <script src="http://labelwriter.com/software/dls/sdk/js/DYMO.Label.Framework.latest.js" type="text/javascript" charset="UTF-8"></script>
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

        <?php include 'quick-print/sections/print-form.php'; ?>
        
			</div>
			
			
			<!-- Footer -->
			<?php include 'global/sections/footer.php'; ?>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
	<!--Footer-->
	<?php include 'global/sections/includes.php'; ?>
  <script src="quick-print/js/print-functions.js"></script>
</body>

</html>
