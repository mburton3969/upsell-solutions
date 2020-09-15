<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
//include 'connection.php';

//Load Variables...
$sku = $_REQUEST['product_code'];
$config = require 'config.php';
$account_token = $config['account_token'];
$secret_key = $config['secret_key'];
$url = 'https://api.sellbrite.com/v1/inventory';
$product_label = $_REQUEST['product_label'];

#Main Functions...

//If cur_qty exists, add to new_qty...
$new_qty = $_REQUEST['product_quantity'];
if($_REQUEST['cur_qty']){
  $new_qty = $_REQUEST['cur_qty'] + $_REQUEST['product_quantity'];
}

//Create Product Object...
$inventory = array(
  "sku" => $sku,
  "warehouse_uuid" => "dfa258cc-0286-496f-b736-7b7001800f1c",
  "available" => $new_qty,
  "bin_location" => $product_label
);

$data['inventory'] = array();
array_push($data['inventory'], $inventory);
//echo json_encode($data,JSON_PRETTY_PRINT);
//die();

// create curl resource
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic '. base64_encode("$account_token:$secret_key")
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//The output string from execution
$output = curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
$x = json_decode($output);
if($x->error){
  $x->response = 'ERROR';
}else{
  $x->response = 'GOOD';
}

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;