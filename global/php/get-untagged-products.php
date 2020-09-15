<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
include 'connection.php';

//Load Variables...



#Main Functions...

//Get Untagged Products...
$rq = "SELECT DISTINCT `upc_code` FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'Listing_SellBrite' AND `shopify_tagged` != 'Yes'";
$rg = mysqli_query($conn, $rq) or die($conn->error);
if(mysqli_num_rows($rg) > 0){
  
  $products = array();
  while($rr = mysqli_fetch_array($rg)){
    $q = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'Listing_SellBrite' AND `shopify_tagged` != 'Yes' AND `upc_code` = '" . $rr['upc_code'] . "' ORDER BY `ID` DESC LIMIT 1";
    $g = mysqli_query($conn, $q) or die($conn->error);
    //$header = mysqli_fetch_array($g);
    
    $r = mysqli_fetch_array($g);
    $head = array();
    foreach($r as $key => $value){
      if(!is_numeric($key)){
        array_push($head, $key);
      }
    }
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