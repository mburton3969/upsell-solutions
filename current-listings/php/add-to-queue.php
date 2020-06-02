<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();
include '../../assets/php/connection.php';

//Load Variables...
$item_id = mysqli_real_escape_string($conn, $_REQUEST['item_id']);
$price = mysqli_real_escape_string($conn, $_REQUEST['price']);
$img = mysqli_real_escape_string($conn, $_REQUEST['img']);
$upc = mysqli_real_escape_string($conn, $_REQUEST['upc']);
$title = mysqli_real_escape_string($conn, $_REQUEST['title']);

//Insert Item...
$iq = "INSERT INTO `ebay_imports`
       (
       `date`,
       `time`,
       `listing_id`,
       `item_title`,
       `item_upc`,
       `product_price`,
       `product_img`,
       `user_id`,
       `user_name`,
       `status`,
       `inactive`
       )
       VALUES
       (
       CURRENT_TIMESTAMP,
       CURRENT_TIMESTAMP,
       '" . $item_id . "',
       '" . $title . "',
       '" . $upc . "',
       '" . $price . "',
       '" . $img . "',
       '" . $_SESSION['user_id'] . "',
       '" . $_SESSION['user_name'] . "',
       'Queued',
       'No'
       )";
mysqli_query($conn, $iq) or die($conn->error);

$x->response = 'GOOD';

$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;