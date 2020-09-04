<?php
//header('Content-Type: application/json');
error_reporting(0);
session_start();

//Load Variables...
$config = require 'config.php';
$api_key = $config['api_key'];
$api_secret_key = $config['api_secret_key'];
$api_version = $config['api_version'];
$redirect_uri = $config['redirect_uri'];
$shop = $config['shop'];
$scopes = 'read_products,write_products';
$resource = 'smart_collections';
$_SESSION['nonce'] = uniqid();

$url = 'https://' . $shop . '.myshopify.com/admin/oauth/authorize?client_id=' . $api_key . '&scope=' . $scopes . '&redirect_uri=' . $redirect_uri . '&state=' . $_SESSION['nonce'] . '&grant_options[]=';

header('Location: '.$url);

/*#Main Functions...
//Create cURL resource.
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'Authorization: Basic '. base64_encode("$api_key:$api_secret_key"),
    'Content-Type: application/json'
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//The output string from execution
$output = curl_exec($ch);
//$x = json_decode($output);
$x = $output;

// close curl resource to free up system resources
curl_close($ch);

//Setup Response Output...
//$response = json_encode($x,JSON_PRETTY_PRINT);
//echo $response;
echo $x;*/