<?php
error_reporting(0);
#
# Digit Eyes Code to Generate and Output JSON
#
#****Dynamic UPC from form****
//$upc_code = $_GET["upc"];
#****Hard Code Test UPC****
$upc_code = $_GET['upc'];
#****Substitute Your Auth Key****
$auth_key = $_GET['auth_key'];
#****Substitute Your App Key****
$de_app_key = $_GET['de_apikey'];

$bl_app_key = $_GET['bl_apikey'];

$wm_app_key = $_GET['wm_apikey'];

#****Generates API Signature****
$signature = base64_encode(hash_hmac('sha1', $upc_code, $auth_key, $raw_output = true));


$de_url = 'https://digit-eyes.com/gtin/v2_0/?upcCode='. $upc_code .'&app_key='. $de_app_key .'&language=en&field_names=all&signature='. $signature;

$bl_url = 'https://api.barcodelookup.com/v2/products?barcode=' . $upc_code . '&formatted=y&key=' . $bl_app_key;

$upc_url = 'https://api.upcitemdb.com/prod/trial/lookup?upc=' . $upc_code;

$wm_url = 'http://api.walmartlabs.com/v1/items/' . $upc_code . '?format=json&apiKey=' . $wm_app_key;

$x->de_data = '';
$x->bl_data = '';
$x->upc_data = '';
$x->wm_data = '';

$x->de_data = file_get_contents($de_url);
if($x->de_data == false){
  $x->bl_data = file_get_contents($bl_url);
}
if($x->bl_data == false && $x->bl_data != ''){
  $x->upc_data = file_get_contents($upc_url);
}
if($x->upc_data == false && $x->upc_data != ''){
  $x->wm_data = file_get_contents($wm_url);
}

$data = json_encode($x);

echo $data;

?>