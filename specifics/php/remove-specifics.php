<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);
include '../../global/php/connection.php';

# Load Variables...
$sid = $_REQUEST['sid'];


# Main Functions...

$q = "UPDATE `oc_filter_description` SET `inactive` = 'Yes' WHERE `filter_id` = '" . $sid . "'";
if(mysqli_query($conn, $q)){
    $x->response = 'GOOD';
    $x->message = 'Option removed successfully!';
}else{
    $x->response = 'ERROR';
    $x->message = 'Error: ' . $conn->error;
}

$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;