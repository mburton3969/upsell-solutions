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
$url = 'https://' . $shop . '.myshopify.com/admin/oauth/access_token';
$code = $_REQUEST['code'];

#Main Functions...
//Create cURL resource.
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'Authorization: Basic '. base64_encode("$api_key:$api_secret_key"),
    'Content-Type: application/json'
);
$post_data = array(
  'client_id' => $api_key,
  'client_secret' => $api_secret_key,
  'code' => $code
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
//The output string from execution
$output = curl_exec($ch);
$x = json_decode($output);
$_SESSION['access_token'] = $x->access_token;

// close curl resource to free up system resources
curl_close($ch);

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;