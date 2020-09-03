<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();
include '../php/connection.php';

//Load Variables...
$listed = $_REQUEST['listed'];
$upc_code = $_REQUEST['upc'];
$listing_message = $_REQUEST['message'];
$request_data = json_encode($_REQUEST);

//INSERT UPC Data...
$q = "INSERT INTO `upc_search_log` 
      (
      `date`,
      `time`,
      `log_type`,
      `upc_code`,
      `data_found`,
      `listed`,
      `listing_message`,
      `listing_data`,
      `request_data`,
      `user_id`,
      `user_name`,
      `inactive`
      )
      VALUES
      (
      CURRENT_TIMESTAMP,
      CURRENT_TIMESTAMP,
      'Listing_SellBrite',
      '" . mysqli_real_escape_string($conn, $upc_code) . "',
      'N/A',
      '" . $listed . "',
      '" . mysqli_real_escape_string($conn, $listing_message) . "',
      '" . $listing_data . "',
      '" . mysqli_real_escape_string($conn, $request_data) . "',
      '" . $_SESSION['user_id'] . "',
      '" . $_SESSION['user_name'] . "',
      'No'
      )";
$g = mysqli_query($conn, $q) or die($conn->error);

//Setup JSON Data...
$x->response = 'GOOD';
$x->message = 'Item Added Successfully!';
$x->upc = $upc_code;


//Format Response...
$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;

?>