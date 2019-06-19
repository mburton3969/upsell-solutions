<?php
//include 'connection.php';

//Load Variables...
$mode = $_POST['env_mode'];
$product_title = $_POST['product_title'];


//Add Item To Database...
$aq = "";
//$ag = mysqli_query($conn, $aq) or die($conn->error);
//$ar = mysqli_fetch_array($ag);


//Get Access Auth...
if($mode == 'SANDBOX'){
  $rurl = 'https://auth.sandbox.ebay.com/oauth2/authorize?client_id=MichaelB-UpsellSo-SBX-9dbf9000b-ae4101bc&response_type=code&redirect_uri=Michael_Burton-MichaelB-Upsell-gzpwqabnj&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/sell.finances.readonly';
}elseif($mode == 'PRODUCTION'){
  $rurl = '';
}else{
  //Error Message...
  $rurl = '#';
}

header('Location: '.$rurl);

?>