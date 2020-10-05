<?php
session_start();
include 'security/check-login.php';
$pageName = 'Specifics';
$pageIcon = 'fas fa-list';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reseller Solutions App</title>
    <?php include 'global/sections/head.php'; ?>
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

			<div class="row">
				<div class="col-md-4">
					<?php include 'specifics/sections/brands-table.php'; ?>
				</div>
				<div class="col-md-4">
					<?php include 'specifics/sections/sizes-table.php'; ?>
				</div>
			</div>
			
			
        
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
	<script src="specifics/js/specifics-functions.js?cb=<?php echo $cache_buster; ?>"></script>
</body>

</html>
