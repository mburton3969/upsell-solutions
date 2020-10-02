<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);
include '../../global/php/connection.php';

# Load Variables...


# Main Functions...

$q = "SELECT * FROM `oc_filter_description` WHERE `inactive` != 'Yes' AND `filter_group_id` = '7'";

if($g = mysqli_query($conn, $q)){
    $options = array();
    while($r = mysqli_fetch_array($g)){
        if($r['filter_group_id'] == '7'){
            array_push($options, $r);
        }
    }
    $x->response = 'GOOD';
    $x->message = 'Option removed successfully!';
    $x->data = $options;
}else{
    $x->response = 'ERROR';
    $x->message = 'Error: ' . $conn->error;
}

$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;