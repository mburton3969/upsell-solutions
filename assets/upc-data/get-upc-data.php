<?php
header('Content-Type: application/json');
error_reporting(0);
include '../php/connection.php';

//Load Variables...
$upc_code = $_REQUEST['upc'];

//Get UPC Data...
$q = "SELECT * FROM `upc_codes` WHERE `upc_code` = '" . $upc_code . "'";
$g = mysqli_query($conn, $q) or die($conn->error);
$r = mysqli_fetch_array($g);

//Setup JSON Data...
$x->upc = $upc_code;


//Format Response...
$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;

?>