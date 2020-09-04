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
$resource = 'smart_collections';
$url = 'https://' . $shop . '.myshopify.com/admin/api/' . $api_version . '/' . $resource . '.json';

#Main Functions...
//Create cURL resource.
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'X-Shopify-Access-Token: ' . $_SESSION['access_token'],
    'Content-Type: application/json'
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//The output string from execution
$output = curl_exec($ch);
$x = json_decode($output);

// close curl resource to free up system resources
curl_close($ch);

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;