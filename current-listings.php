<?php
$pageName = 'Current Listings';
$pageIcon = 'fab fa-ebay';
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

        <?php include 'current-listings/sections/item-cards.php'; ?>
        
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
	<script src="current-listings/js/item-card-functions.js"></script>
</body>

</html>
