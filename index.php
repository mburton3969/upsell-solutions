<?php
session_start();

$_SESSION['ebay_mode'] = 'production';//sandbox or production
$_SESSION['ebay_mode_val'] = false;//true="sandbox" false="production"

if($_SESSION['auth_code'] == '' || !isset($_SESSION['auth_code'])){
  if($_SESSION['ebay_mode'] == 'sandbox'){
    $rurl = 'https://auth.sandbox.ebay.com/oauth2/authorize?client_id=MichaelB-UpsellSo-SBX-9dbf9000b-ae4101bc&response_type=code&redirect_uri=Michael_Burton-MichaelB-Upsell-gzpwqabnj&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/sell.finances';
    header('Location: '.$rurl);
  }elseif($_SESSION['ebay_mode'] == 'production'){
    $rurl = 'https://auth.ebay.com/oauth2/authorize?client_id=MichaelB-UpsellSo-PRD-b520c1333-d6a63876&response_type=code&redirect_uri=Michael_Burton-MichaelB-Upsell-sprmo&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly';
    header('Location: '.$rurl);
  }else{
    //Error...
  }
    
}
$cache_buster = uniqid();
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />  <link rel="stylesheet" href="assets/css/modal-style.css">
  <link rel="stylesheet" href="assets/css/loader.css">
  <script src="assets/js/item-specifics-functions.js?cb=<?php echo $cache_buster; ?>"></script>
</head>
<body onload="get_cats(1);">
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

<form action="assets/php/add-item.php" method="post">
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">UPC Code:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_code" style="width: 100%;" name="product_code" class="form-control" placeholder="UPC Code" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Title:</h4>
                </div>
                <div class="col"><input type="text" id="product_title" style="width: 100%;" name="product_title" class="form-control" placeholder="Title" maxlength="80" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Description:</h4>
                </div>
                <div class="col"><input type="text" id="product_description" style="width: 100%;" name="product_description" class="form-control" placeholder="Description" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Product Details:</h4>
                </div>
                <div class="col" id="item_specifics">
                  <button type="button" id="add_specific" style="width: 32%;display:inline;" name="add_specific" class="form-control btn btn-primary" onclick="add_specific();"><i class="fas fa-plus"></i></button>
                  <input type="text" id="product_brand" style="width: 32%;display:inline;" name="product_brand" class="form-control" placeholder="Brand">
                  <!--
                  <input type="text" id="product_color" style="width: 32%;display:inline;" name="product_color" class="form-control" placeholder="Color">
                  <input type="text" id="product_sizetype" style="width: 32%;display:inline;" name="product_sizetype" class="form-control" placeholder="Size Type">
                  <input type="text" id="product_style" style="width: 32%;display:inline;" name="product_style" class="form-control" placeholder="Style">
                  <input type="text" id="product_sleevelength" style="width: 32%;display:inline;" name="product_sleevelength" class="form-control" placeholder="Sleeve Length">
                  -->
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Custom Label:</h4>
                </div>
                <div class="col-md-6"><input type="text" id="product_label" style="width: 100%;" name="product_label" class="form-control" placeholder="Custom Label" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Category:</h4>
                </div>
                <div class="col-md-6" id="cat_box">
                  <select id="product_category" name="product_category" class="form-control" Required>
                    <option value="">Select Category</option>
                  </select>
              </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Condition:</h4>
                </div>
                <div class="col-md-6">
                  <select id="product_condition" style="width: 100%;" name="product_condition" class="form-control" Required>
                    <option value="">Select Condition</option>
                    <option value="1000">New with tags/box</option>
                    <option value="1500">New without tags/box</option>
                    <option value="1750">New with defects</option>
                    <option value="3000">Pre-owned</option>
                  </select>
                </div>
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
                  <a id="img1_link" href="#" target="_blank"><img id="product_image1" name="product_image1" style="width: 33%;"></a>
                    <input type="hidden" id="img_url1" name="img_url1" />
                  <a id="img2_link" href="#" target="_blank"><img id="product_image2" name="product_image2" style="width: 33%;"></a>
                    <input type="hidden" id="img_url2" name="img_url2" />
                  <a id="img3_link" href="#" target="_blank"><img id="product_image3" name="product_image3" style="width: 33%;"></a>
                    <input type="hidden" id="img_url3" name="img_url3" />
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
                <div class="col-md-6"><input type="text" id="product_price" style="width: 100%;" name="product_price" class="form-control" placeholder="Price" Required></div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Quantity:</h4>
                </div>
                <div class="col-md-6"><input type="number" id="product_quantity" style="width: 100%;" name="product_quantity" class="form-control" placeholder="Quantity" Required></div>
            </div>
        </div>
    </div>
    <!--<div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Package Dimensions:</h4>
                </div>
                <div class="col-md-6">
                  <input type="number" style="width: 32%;display:inline;" id="product_pkg_width" name="product_pkg_width" class="form-control" placeholder="Width (inches)" Required>
                  <input type="number" style="width: 32%;display:inline;" id="product_pkg_length" name="product_pkg_length" class="form-control" placeholder="Length (inches)" Required>
                  <input type="number" style="width: 32%;display:inline;" id="product_pkg_depth" name="product_pkg_depth" class="form-control" placeholder="Depth (inches)" Required>
                </div>
            </div>
        </div>
    </div>-->
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left">Package Weight:</h4>
                </div>
                <div class="col-md-6">
                  <input type="number" style="width: 49%;display:inline;" id="product_pkg_lbs" name="product_pkg_lbs" class="form-control" placeholder="Pounds" Required>
                  <input type="number" style="width: 49%;display:inline;" id="product_pkg_oz" name="product_pkg_oz" class="form-control" placeholder="Ounces" Required>
                </div>
            </div>
        </div>
    </div>
    <!--<div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <h4 class="text-left">Package Type:</h4>
                </div>
                <div class="col-md-6">
                  <select id="product_ship_option" style="width: 100%;" name="product_ship_option" class="form-control">
                    <option value="">Select Package Type</option>
                    <option value="BulkyGoods"></option>
                    <option value="Caravan"></option>
                    <option value="Cars"></option>
                    <option value="Europallet"></option>
                    <option value="ExpandableToughBags"></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                  </select>
                </div>
            </div>
        </div>
    </div>-->
    <!--<div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <h4 class="text-left">Shipping Service: &nbsp; <small>[<a href="https://www.ebay.com/shp/Calculator" target="_blank">Shipping Calculator</a>]</small></h4>
                </div>
                <div class="col-md-6">
                  <select id="product_ship_option" style="width: 100%;" name="product_ship_option" class="form-control" Required>
                    <option value="">Select Shipping Option</option>
                    <option value="USPSPriority">USPS Priority Mail (1-3 Business Days)</option>
                    <option value="USPSFirstClass">USPS First Class Package (2-3 Business Days)</option>
                  </select>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <h4 class="text-left">Returns Accepted?</h4>
                </div>
                <div class="col-md-6">
                  <select id="returns_accepted_option" style="width: 100%;" name="returns_accepted_option" class="form-control" Required>
                    <option value="">Select Returns Option</option>
                    <option value="ReturnsAccepted">Returns Accepted</option>
                    <option value="ReturnsNotAccepted">Returns Not Accepted</option>
                  </select>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <h4 class="text-left">Returns Accepted Within?</h4>
                </div>
                <div class="col-md-6">
                  <select id="returns_accepted_within_option" style="width: 100%;" name="returns_accepted_within_option" class="form-control" Required>
                    <option value="">Select Returns Time Option</option>
                    <option value="Days_14">14 Days</option>
                    <option value="Days_30">30 Days</option>
                    <option value="Days_60">60 Days</option>
                  </select>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <h4 class="text-left">Refund Method?</h4>
                </div>
                <div class="col-md-6">
                  <select id="refund_option" style="width: 100%;" name="refund_option" class="form-control" Required>
                    <option value="">Select Refund Option</option>
                    <option value="MoneyBack">Money Back Only</option>
                    <option value="MoneyBackOrReplacement">Money Back Or Replacement</option>
                  </select>
                </div>
            </div>
        </div>
    </div>
    <div style="padding: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <h4 class="text-left">Who Pays Return Shipping?</h4>
                </div>
                <div class="col-md-6">
                  <select id="return_shipping_option" style="width: 100%;" name="return_shipping_option" class="form-control" Required>
                    <option value="">Select Return Shipping Option</option>
                    <option value="Buyer">Buyer</option>
                    <option value="Seller">Seller</option>
                  </select>
                </div>
            </div>
        </div>
    </div>-->
  <br>
    <input type="hidden" id="cur_cat" name="cur_cat" />
    <div class="text-center">
        <div class="btn-group" role="group" style="margin: 0px;padding: 10px;">
            <!--<button class="btn btn-light btn-lg border rounded-0 shadow-sm" type="button">Cancel</button>-->
            <input type="hidden" name="env_mode" value="PRODUCTION"><!--'SANDBOX' or 'PRODUCTION'-->
            <?php ?>
            <button class="btn btn-success btn-lg text-white border rounded-0 border-dark shadow-sm" type="submit">Submit To Ebay</button>
        </div>
    </div>
    <input type="hidden" id="item_specifics_array" name="item_specifics_array" />
</form>
    <br>
  <?php include 'modals/success-modal.php'; ?>
  <?php include 'modals/error-modal.php'; ?>
</body>
<script src="assets/js/upc-lookup-api.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/upc-parsers.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/errors.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/chrome-detection.js?cb=<?php echo $cache_buster; ?>"></script>
<script src="assets/js/get-categories.js?cb=<?php echo $cache_buster; ?>"></script>
  <?php
  if($_GET['res_code'] == 204){
    echo '<script>
          $("#successModal").modal("show");
          </script>';
  }
  ?>
</html>

