<?php
header('Content-Type: application/json');
session_start();
error_reporting(0);
include '../../global/php/connection.php';

//Load Variables...
$size = $_REQUEST['size'];
$original = $_REQUEST['original'];
$now = $_REQUEST['now'];



#Main Functions...
//Log Activity...
$iq = "INSERT INTO `qp_log`
        (
        `date`,
        `time`,
        `user_id`,
        `user_name`,
        `size`,
        `original`,
        `now`,
        `inactive`
        )
        VALUES
        (
        CURRENT_TIMESTAMP,
        CURRENT_TIMESTAMP,
        '" . $_SESSION['user_id'] . "',
        '" . $_SESSION['user_name'] . "',
        '" . $size . "',
        '" . $original . "',
        '" . $now . "',
        'No'
        )";
mysqli_query($conn, $iq) or die($conn->error);

$x->response = 'GOOD';
$x->message = 'Activity Logged Successfully!';


//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;