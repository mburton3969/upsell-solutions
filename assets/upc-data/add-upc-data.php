<?php
header('Content-Type: application/json');
error_reporting(0);
include '../php/connection.php';

//Load Variables...
$upc_code = $_REQUEST['upc'];

//INSERT UPC Data...
/*$q = "INSERT INTO `upc_codes` 
      (
      `date`,
      `time`,
      `pallet_id`,
      `upc_code`,
      `category`,
      `brand`,
      `item_title`,
      `item_description`,
      `long_description`,
      `size`,
      `color`,
      `img1`,
      `img2`,
      `img3`,
      `img4`,
      `img5`,
      `retail_price`,
      `item_weight`,
      `item_source`,
      `inactive`
      )
      VALUES
      (
      
      )";
$g = mysqli_query($conn, $q) or die($conn->error);

//Setup JSON Data...
$x->response = 'GOOD';
$x->message = 'Item Added Successfully!';
$x->upc = $upc_code;


//Format Response...
$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;*/

?>