<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();
include '../../assets/php/connection.php';

//Load Variables...


$x->response = 'GOOD';
//Get Queued Items...
$q = "SELECT * FROM `ebay_imports` WHERE `inactive` != 'Yes' AND `user_id` = '" . $_SESSION['user_id'] . "' AND `status` = 'Queued'";
$g = mysqli_query($conn, $q) or die($conn->error);
$i = 0;
while($r = mysqli_fetch_array($g)){
  $d = '';
  $d->ItemID = $r['listing_id'];
  $d->upc = $r['item_upc'];
  $d->title = $r['item_title'];
  $d->img = $r['product_img'];
  $d->price = $r['product_price'];
  $x->item[$i] = $d;
  $i++;
}


      
$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;