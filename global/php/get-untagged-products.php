<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
include 'connection.php';

//Load Variables...



#Main Functions...

//Get Untagged Products...
$q = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'Listing_SellBrite' AND `shopify_tagged` != 'Yes'";
$g = mysqli_query($conn, $q) or die($conn->error);
if(mysqli_num_rows($g) > 0){
  $header = mysqli_fetch_array($g);
  $head = array();
  foreach($header as $key => $value){
    if(!is_numeric($key)){
      array_push($head, $key);
    }
  }
  $products = array();
  while($r = mysqli_fetch_array($g)){
    $product = '';
    foreach($head as $h){
      //echo $r[$h];
      $product->$h = $r[$h];
    }
    array_push($products,$product);
  }
  $x->response = 'GOOD';
  $x->products = $products;
}else{
  $x->response = 'ERROR';
  $x->message = 'No Products Founds...';
}

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;