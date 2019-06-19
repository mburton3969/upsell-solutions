<?php
session_start();
$_SESSION['ebay_mode'] = 'sandbox';//sandbox or production
if($_SESSION['auth_code'] == '' || !isset($_SESSION['auth_code'])){
  if($_SESSION['ebay_mode'] == 'sandbox'){
    $rurl = 'https://auth.sandbox.ebay.com/oauth2/authorize?client_id=MichaelB-UpsellSo-SBX-9dbf9000b-ae4101bc&response_type=code&redirect_uri=Michael_Burton-MichaelB-Upsell-gzpwqabnj&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/sell.finances.readonly';
    header('Location: '.$rurl);
  }elseif($_SESSION['ebay_mode'] == 'production'){
    $rurl = 'https://auth.ebay.com/oauth2/authorize?client_id=MichaelB-UpsellSo-PRD-b520c1333-d6a63876&response_type=code&redirect_uri=Michael_Burton-MichaelB-Upsell-sprmo&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly';
    header('Location: '.$rurl);
  }else{
    //Error...
  }
    
}
?>
<html>
<head>
	<title>API Test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/modal-style.css">
  <link rel="stylesheet" href="assets/css/loader.css">
</head>
<body>
  <div id="loader" class="loader" style="display:none;">Loading...</div>
    <div>
        <div class="container">
          
          <!--Chrome Browser Notification-->
          <div class="row" id="chromeNotification"></div>
          
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center bg-light shadow" style="margin: 8px;padding: 10px;">Product Detail Form</h1>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12"><br></div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <input class="border rounded border-dark form-control-lg" type="text" style="width:100%;margin:2px;" placeholder="Scan UPC Code Here" id="upc_code" name="upc_code" onkeyup="lookup_upc(event,this.value);">
                    <p style="color:red;font-weight:bold;" id="response_message"></p>
                </div>
            </div>
        </div>
    </div>
    <br>

<form action="assets/php/submit-item.php" method="post">
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Title:</h4>
                </div>
                <div class="col"><input type="text" id="product_title" style="width: 100%;" name="product_title"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Custom Label:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_label" style="width: 100%;" name="product_label"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Category:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_category" style="width: 100%;" name="product_category"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">UPC Code:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_code" style="width: 100%;" name="product_code"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Condition:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_condition" style="width: 100%;" name="product_condition"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Images:</h4>
                    <div class="text-left">
                        <input class="btn btn-primary text-center text-body bg-light border rounded border-dark shadow-sm" type="file" value="Upload">
                    </div>
                </div>
                <div class="col-md-6">
                    <img id="product_image1" name="product_image1" style="width: 33%;">
                    <img id="product_image2" name="product_image2" style="width: 33%;">
                    <img id="product_image3" name="product_image3" style="width: 33%;">
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Price:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_price" style="width: 100%;" name="product_price"></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Quantity:</h4>
                </div>
                <div class="col-md-6"><input type="number" id="product_quantity" style="width: 100%;" name="product_quantity"></div>
            </div>
        </div>
    </div><br>
    <div class="text-center">
        <div class="btn-group" role="group" style="margin: 0px;padding: 10px;">
            <!--<button class="btn btn-light btn-lg border rounded-0 shadow-sm" type="button">Cancel</button>-->
            <input type="hidden" name="env_mode" value="SANDBOX"><!--'SANDBOX' or 'PRODUCTION'-->
            <button class="btn btn-success btn-lg text-white border rounded-0 border-dark shadow-sm" type="submit">Submit To Ebay [SANDBOX MODE]</button>
        </div>
    </div>
</form>
    <br>
  <?php include 'modals/success-modal.php'; ?>
  <?php include 'modals/error-modal.php'; ?>
</body>
<script src="assets/js/upc-lookup-api.js"></script>
<script src="assets/js/upc-parsers.js"></script>
<script src="assets/js/errors.js"></script>
<script src="assets/js/chrome-detection.js"></script>
  <?php
  if($_GET['res_code'] == 204){
    echo '<script>
          $("#successModal").modal("show");
          </script>';
  }
  ?>
</html>

