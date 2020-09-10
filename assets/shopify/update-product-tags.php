<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();

//Load Variables...
$config = require 'config.php';
$api_key = $config['api_key'];
$api_secret_key = $config['api_secret_key'];
$api_version = $config['api_version'];
$shop = $config['shop'];
$resource = 'products';
$product_id = $_REQUEST['product_id'];
$tags = $_REQUEST['tags'];
$url = 'https://' . $shop . '.myshopify.com/admin/api/' . $api_version . '/' . $resource . '/' . $product_id . '.json';

//Setup POST Data...
$product = array('id' => $product_id,'tags' => $tags);
$post_data = array('product' => $product);
//echo json_encode($post_data, JSON_PRETTY_PRINT);
//die();
#Main Functions...
//Create cURL resource.
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'X-Shopify-Access-Token: ' . $_SESSION['shopify_access_token'],
    'Content-Type: application/json'
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

//The output string from execution
$output = curl_exec($ch);
$x = json_decode($output);

// close curl resource to free up system resources
curl_close($ch);

//Setup Response Output...
$x->response = 'GOOD';
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;