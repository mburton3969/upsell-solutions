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
$app_key = $_GET['apikey'];

#****Generates API Signature****
$signature = base64_encode(hash_hmac('sha1', $upc_code, $auth_key, $raw_output = true));

#***Dynamic UPC Production***
//$url = 'https://digit-eyes.com/gtin/v2_0/?upc_code='.$_GET["upc"].'&app_key='. $app_key
.'&language=en&field_names=all&signature='. $signature .'';

#***Hard Code UPC Test***
$url = 'https://digit-eyes.com/gtin/v2_0/?upc_code='. $upc_code .'&app_key='. $app_key
.'&language=en&field_names=all&signature='. $signature;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);
echo $data;

//echo $signature;
?>