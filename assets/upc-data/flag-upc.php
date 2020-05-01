<?php
error_reporting(0);
include '../php/connection.php';

//Load Variables...
$upc = $_REQUEST['upc'];


//Flag UPC...
$q = "UPDATE `upc_codes` SET `accurate` = 'No' WHERE `upc_code` = '" . $upc . "'";
mysqli_query($conn, $q) or die($conn->error);

$x->response = 'GOOD';
$x->message = 'UPC Flagged for Inaccuracy!';

$response = json_encode($x);
echo $response;