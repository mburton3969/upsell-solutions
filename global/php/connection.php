<?php
if($_SERVER['HTTP_HOST'] == 'sandbox.reseller-solutions.com'){
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'reseller_app';
}else{
    $db_host = 'localhost';
    $db_user = 'reseller_user';
    $db_pass = ';yX[=,qc=-v#';
    $db_name = 'reseller_app';
}

$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name) or die($conn->error);
