<?php
header('Content-Type: application/json');
error_reporting(0);
include '../php/connection.php';

//Load Variables...


//Check if UPC Exists in DB...
/*$uq = "UPDATE `upc_codes` SET 
        `brand` = '" . $upc_code . "',
        
        WHERE 
        `upc_code` = '" . $upc_code . "'";*/