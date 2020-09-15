<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
//include 'connection.php';

//Load Variables...
$sku = $_REQUEST['sku'];
$config = require 'config.php';
$account_token = $config['account_token'];
$secret_key = $config['secret_key'];
$url = 'https://api.sellbrite.com/v1/products/' . $sku;

#Main Functions...
// create curl resource
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'Authorization: Basic '. base64_encode("$account_token:$secret_key")
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//The output string from execution
$output = curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
//echo count($output);
$x = json_decode($output);
if($x->error){
  $x->response = 'ERROR';
}else{
  $x->response = 'GOOD';
}
//var_dump($x);

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;