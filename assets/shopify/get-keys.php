<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();
include '../php/connection.php';

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
$_SESSION['shopify_access_token'] = $x->access_token;

$q = "SELECT * FROM `credentials` WHERE `shop` = '" . $shop . "'";
$g = mysqli_query($conn, $q) or die($conn->error);
if(mysqli_num_rows($g) > 0){
  $uq = "UPDATE `credentials` SET `date` = CURRENT_TIMESTAMP, `time` = CURRENT_TIMESTAMP, `token` = '" . mysqli_real_escape_string($conn, $x->access_token) . "' WHERE `shop` = '" . $shop . "'";
  mysqli_query($conn, $uq) or die($conn->error);
}else{
  $iq = "INSERT INTO `credentials` 
         (
         `date`,
         `time`,
         `shop`,
         `token`,
         `inactive`
         )
         VALUES
         (
         CURRENT_TIMESTAMP,
         CURRENT_TIMESTAMP,
         '" . $shop . "',
         '" . mysqli_real_escape_string($conn, $x->access_token) . "',
         'No'
         )";
  mysqli_query($conn, $iq) or die($conn->error);
}

// close curl resource to free up system resources
curl_close($ch);

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;