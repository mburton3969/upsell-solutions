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

  <?php
  if($_GET['res_code'] == 204){
    echo '<script>
          $("#successModal").modal("show");
          </script>';
  }
  
  if($_GET['retry'] == 'Yes'){
    
    echo '<script>';
    echo '(function(){';
    echo 'document.getElementById("loader").style.display = "inline";';
    //eBay Categories...
    $timer = 500;
    $clvl = 1;
    if(isset($_SESSION['form_data']['product_category_2']) && $_SESSION['form_data']['product_category_2'] != ''){
      echo 'setTimeout(function(){get_cats(2,' . $_SESSION['form_data']['product_category_1'] . ',"' . $_SESSION['form_data']['product_category_2'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_2'] . '";},' . $timer . ');
      console.log("Cat2");';
      $timer = $timer + 500;
      $clvl = 2;
    }
    if(isset($_SESSION['form_data']['product_category_3']) && $_SESSION['form_data']['product_category_3'] != ''){
      echo 'setTimeout(function(){get_cats(3,' . $_SESSION['form_data']['product_category_2'] . ',"' . $_SESSION['form_data']['product_category_3'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_3'] . '";},' . $timer . ');
      console.log("Cat3");';
      $timer = $timer + 500;
      $clvl = 3;
    }
    if(isset($_SESSION['form_data']['product_category_4']) && $_SESSION['form_data']['product_category_4'] != ''){
      echo 'setTimeout(function(){get_cats(4,' . $_SESSION['form_data']['product_category_3'] . ',"' . $_SESSION['form_data']['product_category_4'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_4'] . '";},' . $timer . ');
      console.log("Cat4");';
      $timer = $timer + 500;
      $clvl = 4;
    }
    if(isset($_SESSION['form_data']['product_category_5']) && $_SESSION['form_data']['product_category_5'] != ''){
      echo 'setTimeout(function(){get_cats(5,' . $_SESSION['form_data']['product_category_4'] . ',"' . $_SESSION['form_data']['product_category_5'] . '");
      document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_5'] . '";},' . $timer . ');
      console.log("Cat5");';
      $timer = $timer + 500;
      $clvl = 5;
    }
    
    echo 'setTimeout(function(){
            //var nCatLevel = catLevel + 1;
            var cl = document.getElementById("product_category_' . $clvl . '").value;
            getItemSpecifics(cl);
            document.getElementById("cur_cat").value = "' . $_SESSION['form_data']['product_category_'.$clvl] . '";
            console.log("clvl: "+cl);
          },' . ($timer + 1500) . ');
          ';
    
    //Item Specifics...
    $isa = explode(',',$_SESSION['form_data']['item_specifics_array']);
    echo 'setTimeout(function(){';
    foreach($isa as $is){
      //echo 'new_specific("' . $is . '","Bypass");';
      echo 'document.getElementById("product_' . $is . '").value = "' . $_SESSION['form_data']['product_' . $is] . '";';
      
    }
    echo '},' . ($timer + 6000) . ');';
    
    //Store Categories...
    echo 'setTimeout(function(){document.getElementById("product_store_category_1").value = "' . $_SESSION['form_data']['product_store_category_1'] . '";},' . ($timer + 4500) . ');
    ';
    $stimer = 0;
    $sclvl = 0;
    if(isset($_SESSION['form_data']['product_category_2']) && $_SESSION['form_data']['product_store_category_2'] != ''){
      echo 'setTimeout(function(){get_store_cats(2,' . $_SESSION['form_data']['product_store_category_1'] . ',"' . $_SESSION['form_data']['product_store_category_2'] . '");},750);
      console.log("StoreCat2");';
      $stimer = $stimer + 2500;
      $sclvl = 1;
      echo 'setTimeout(function(){
              document.getElementById("product_store_category_2").value = "' . $_SESSION['form_data']['product_store_category_2'] . '";
              document.getElementById("cur_store_cat").value = "' . $_SESSION['form_data']['product_store_category_2'] . '";
            },' . $stimer . ');';
    }
    
    
    //81 Store Cat 1...
    if(isset($_SESSION['form_data']['product_81_store_category_1']) && $_SESSION['form_data']['product_81_store_category_1'] != ''){
      echo 'console.warn("81 Store Category 1: ' . $_SESSION['form_data']['product_81_store_category_1'] . '");';
      echo 'setTimeout(function(){get_81_store_cats(1,"0","' . $_SESSION['form_data']['product_81_store_category_1'] . '");
      document.getElementById("cur_81_cat").value = "' . $_SESSION['form_data']['product_81_store_category_1'] . '";},' . $timer . ');
      console.log("81StoreCat1");';
      $timer = $timer + 500;
    }
    //81 Store Cat 2...
    if(isset($_SESSION['form_data']['product_81_store_category_2']) && $_SESSION['form_data']['product_81_store_category_2'] != ''){
      echo 'console.warn("81 Store Category 2: ' . $_SESSION['form_data']['product_81_store_category_2'] . '");';
      echo 'setTimeout(function(){get_81_store_cats(2,"' . $_SESSION['form_data']['product_81_store_category_1'] . '","' . $_SESSION['form_data']['product_81_store_category_2'] . '");
      document.getElementById("cur_81_cat").value = "' . $_SESSION['form_data']['product_81_store_category_2'] . '";
      document.getElementById("loader").style.display = "none";},' . $timer . ');
      console.log("81StoreCat2");';
      $timer = $timer + 500;
    }
    //81 Store Cat 3...
    if(isset($_SESSION['form_data']['product_81_store_category_3']) && $_SESSION['form_data']['product_81_store_category_3'] != ''){
      echo 'console.warn("81 Store Category 3: ' . $_SESSION['form_data']['product_81_store_category_3'] . '");';
      echo 'setTimeout(function(){get_81_store_cats(3,"' . $_SESSION['form_data']['product_81_store_category_2'] . '","' . $_SESSION['form_data']['product_81_store_category_3'] . '");
      document.getElementById("cur_81_cat").value = "' . $_SESSION['form_data']['product_81_store_category_3'] . '";
      document.getElementById("loader").style.display = "none";},' . $timer . ');
      console.log("81StoreCat3");';
      $timer = $timer + 500;
    }
    
    echo 'setTimeout(function(){
            document.getElementById("loader").style.display = "none";
          },' . $timer . ');';
    
    echo '})();';
    echo '</script>';
  }//End of Retry mode...
  
  if($_REQUEST['upc_code'] != ''){
    echo '<script>
            (function(){
              lookup_upc(\'BYPASS\',\'' . $_REQUEST['upc_code'] . '\');
            })();
          </script>';
  }
?>
</html>
