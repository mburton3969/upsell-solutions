<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
//include 'connection.php';

//Load Variables...
$sku = '12345';
$config = require 'config.php';
$account_token = $config['account_token'];
$secret_key = $config['secret_key'];
$url = 'https://api.sellbrite.com/v1/products/' . $sku;

#Main Functions...

//Create Product Object...
$image_list = array(
  "https://usabilitygeek.com/wp-content/uploads/2016/08/usability-testing-prototype.jpg"
);

$product = array(
  "package_unit_of_length" => "inches",
  "package_unit_of_weight" => "pounds",
  "image_list" => $image_list,
  "name" => "Testing Name 2",
  "condition" => "new",
  "brand" => "My Brand",
  "manufacturer" => "My Brand",
  "description" => "This is my brand product for testing",
  "price" => 80,
  "msrp" => 179.99,
  "category_name" => "Test",
  "upc" => "54321"
);
//echo json_encode($product,JSON_PRETTY_PRINT);
//die();

// create curl resource
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic '. base64_encode("$account_token:$secret_key")
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//The output string from execution
$output = curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
$x = json_decode($output);

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;