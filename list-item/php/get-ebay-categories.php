<?php
header('Content-Type: application/json');
error_reporting(0);
include '../../global/php/connection.php';

//Load Variables...
$cid = $_REQUEST['cid'];

//Set Array...
//$cat_array = [];
$x->response = 'GOOD';

//Get Categories...
$pcq = "SELECT * FROM `ebay_categories` WHERE `category_id` = '" . $cid . "'";
$pcg = mysqli_query($conn, $pcq) or die($conn->error);
$pcr = mysqli_fetch_array($pcg);
$cat_array[$pcr['category_level']] = $pcr['category_id'];
//array_push($cat_array, array($pcr['category_level'] => $pcr['category_id']));
$level = $pcr['category_level'];
$cat_id = $pcr['parent_id'];
$x->max_cat_level = $level;

$i = $level;
while($i <= $level && $i > 0){
  //echo $i . '<br>';
  $pcq = "SELECT * FROM `ebay_categories` WHERE `category_id` = '" . $cat_id . "'";
  $pcg = mysqli_query($conn, $pcq) or die($conn->error);
  $pcr = mysqli_fetch_array($pcg);
  $cat_array[$pcr['category_level']] = $pcr['category_id'];
  //array_push($cat_array, array($pcr['category_level'] => $pcr['category_id']));
  $cat_id = $pcr['parent_id'];
  $i--;
}

$x->cats = $cat_array;

$res = json_encode($x,JSON_PRETTY_PRINT);
echo $res;