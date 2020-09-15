<?php
header('Content-Type: application/json');
error_reporting(0);
include '../../assets/php/connection.php';

//Load Variables...



#Main Functions...

//Get Un-Tagged Items from database...
$tq = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `shopify_tagged` != 'Yes'";
$tg = mysqli_query($conn, $tg) or die($conn->error);
while($tr = mysqli_fetch_array($tg)){
  
  $url = 'https://' . $_SERVER['HTTP_HOST'] . '/assets/shopify/get-all-products.php';
  // create curl resource
  $ch = curl_init();
  //Create cURL Headers.
  $headers = array(
      'Authorization: Basic '. base64_encode("$account_token:$secret_key")
  );
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //The output string from execution
  $output = curl_exec($ch);
  // close curl resource to free up system resources
  curl_close($ch);
  
}

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;