<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();

//Load Variables...



#Main Functions...
$_SESSION['form_data'] = $_REQUEST;
$x->response = 'GOOD';
$x->message = 'Request data successfully Sessionized';

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;