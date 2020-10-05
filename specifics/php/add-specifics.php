<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);
include '../../global/php/connection.php';

# Load Variables...
$mode = $_REQUEST['mode'];
$value = $_REQUEST['value'];
$filter_category = $_REQUEST['filter_cat'];


# Main Functions...

$q = "INSERT INTO `oc_filter_description` 
        (
        `language_id`,
        `filter_group_id`,
        `name`,
        `filter_category`
        )
        VALUES
        (
        '1',
        '" . $mode . "',
        '" . mysqli_real_escape_string($conn, $value) . "',
        '" . $filter_category . "'
        )";
if(mysqli_query($conn, $q)){
    $x->response = 'GOOD';
    $x->message = 'Option added successfully!';
    $x->ID = $conn->insert_id;
}else{
    $x->response = 'ERROR';
    $x->message = 'Error: ' . $conn->error;
}

$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;