<?php
session_start();
error_reporting(0);
$_SESSION['app_version'] = '3.4.0';//Soon this will be moved to the validate script...
include 'assets/php/connection.php';
$config = require 'assets/php/ebay-config.php';
$maint = 'No';//Site Under Maintenance? Yes or No...
if($maint == 'Yes' && $_GET['bypass'] != 'Yes'){
	header('Location: maintenance.php');
}
$_SESSION['ebay_mode'] = 'production';//sandbox or production
$env_mode = $_SESSION['ebay_mode'];
$_SESSION['ebay_mode_val'] = false;//true="sandbox" false="production"

if($_SESSION['auth_code'] == '' || !isset($_SESSION['auth_code'])){
  if($_SESSION['ebay_mode'] == 'sandbox'){
    $rurl = 'https://auth.sandbox.ebay.com/oauth2/authorize?client_id=' . $config[$env_mode]['credentials']['appId'] . '&response_type=code&redirect_uri=' . $config[$env_mode]['ruName'] . '&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/sell.finances';
    header('Location: '.$rurl);
  }elseif($_SESSION['ebay_mode'] == 'production'){
    $rurl = 'https://auth.ebay.com/oauth2/authorize?client_id=' . $config[$env_mode]['credentials']['appId'] . '&response_type=code&redirect_uri=' . $config[$env_mode]['ruName'] . '&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly';
    header('Location: '.$rurl);
  }else{
    //Error...
    echo 'ERROR';
  }
}
if($_SESSION['user_token'] == '' || !isset($_SESSION['user_token'])){
  if($_SESSION['refresh_token'] == '' || !isset($_SESSION['refresh_token'])){
    $_SESSION['auth_code'] = '';
    echo '<script>
            window.location = "http://' . $_SERVER['HTTP_HOST'] . '";
          </script>';
  }else{
    $trurl = 'assets/php/refresh-token-test.php';
    echo '<script>
            window.location = "' . $trurl . '";
          </script>';
  }
}
$cache_buster = uniqid();

//Check for Previous form-data...
if($_GET['retry'] == 'Yes'){
  echo '<script>
          var retry = true;
        </script>';
}
$pageName = 'Product Lister';
$pageIcon = 'fas fa-satellite-dish';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reseller Solutions App</title>
    <?php include 'global/sections/head.php'; ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />  <link rel="stylesheet" href="assets/css/modal-style.css">
  <link rel="stylesheet" href="assets/css/loader.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script src="assets/js/globals.js"></script>
  <link href="global/css/toggle.css" rel="stylesheet" />
</head>

<body onload="get_cats(1);get_store_cats(1,'',25334048017);format_ebay();<?php if($_REQUEST['rety'] != 'Yes'){ echo 'get_81_store_cats(1,\'0\');';} ?>">
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
        <?php //include 'list-item/sections/title-bar.php'; ?>
          
        <?php include 'list-item/sections/counter-bar.php'; ?>
        
        <?php include 'list-item/sections/upc-search-bar.php'; ?>
        
        <?php include 'list-item/sections/listing-form.php'; ?>
          
        
			</div>
			
			
			<!-- Footer -->
			<?php include 'global/sections/footer.php'; ?>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
  
  <!-- Modals -->
  <?php include 'list-item/modals/success-modal.php'; ?>
  <?php include 'list-item/modals/error-modal.php'; ?>
  <?php include 'list-item/modals/img-upload-modal.php'; ?>
	
	<!--Footer-->
	<?php include 'global/sections/includes.php'; ?>
  
  
</body>
  
  <script src="assets/js/item-specifics-functions.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/upc-lookup-api.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/upc-parsers.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/errors.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/chrome-detection.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/get-categories.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/img-handler.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/item-price-functions.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/product-img-uploader.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="assets/js/formatting-functions.js?cb=<?php echo $cache_buster; ?>"></script>
  <script src="list-item/js/listing-detail-functions.js?cb=<?php echo $cache_buster; ?>"></script>

  <?php include 'list-item/js/retry-functions.php'; ?>
  <?php 
    if($_REQUEST['read'] != ''){
      echo '<script>
              get_item_details(' . $_REQUEST['read'] . ');
            </script>';
    }
  ?>
</html>
