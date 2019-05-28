<?php
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

//echo $signature;


#***Dynamic UPC Production***
//$url = 'https://digit-eyes.com/gtin/v2_0/?upc_code='.$_GET["upc"].'&app_key='. $app_key .'&language=en&field_names=all&signature='. $signature .'';

#***Hard Code UPC Test***
//$qry = '?upc_code='. $upc_code .'&app_key='. $app_key .'&language=en&field_names=all&signature='. $signature;
//$url = 'https://digit-eyes.com/gtin/v2_0/';

$de_url = 'https://digit-eyes.com/gtin/v2_0/?upcCode='. $upc_code .'&app_key='. $de_app_key .'&language=en&field_names=all&signature='. $signature;

$bl_url = 'https://api.barcodelookup.com/v2/products?barcode=' . $upc_code . '&formatted=y&key=' . $bl_app_key;

$upc_url = 'https://api.upcitemdb.com/prod/trial/lookup?upc=' . $upc_code;


/*$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_URL, $url . $qry);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);
echo $data;*/

$data = file_get_contents($upc_url);
echo $data;

//echo $signature;*/
?>