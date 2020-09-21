<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();
include '../php/connection.php';
$s_conn = mysqli_connect('localhost','outfitte_store','+F%JW[$YDOR(','outfitte_opencart') or die('Error: ' . $s_conn->error . ' on line 5 of update-product-tags.php');

//Load Variables...
$config = require 'config.php';
$api_key = $config['api_key'];
$api_secret_key = $config['api_secret_key'];
$api_version = $config['api_version'];
$shop = $config['shop'];
$resource = 'products';
$product_id = $_REQUEST['product_id'];
$upc_code = $_REQUEST['upc_code'];
$url = 'https://' . $shop . '.myshopify.com/admin/api/' . $api_version . '/' . $resource . '/' . $product_id . '.json';

//Get Tags from Database...
$tags_array = array();
$tq = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` = 'Listing_SellBrite' AND `shopify_tagged` != 'Yes' AND `upc_code` = '" . $upc_code . "' ORDER BY `ID` DESC LIMIT 1";
$tg = mysqli_query($conn, $tq) or die($conn->error);
$tr = mysqli_fetch_array($tg);
$td = json_decode($tr['request_data']);

//Get Gender...
$prod_81_cat_1 = $td->product_81_store_category_1;
$gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_1 . "'";
$gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
$gcr = mysqli_fetch_array($gcg);
$cat1 = $gcr['name'];
$cat1 = str_replace('Womens ','',$cat1);
$cat1 = str_replace('Mens ','',$cat1);
$cat1 = str_replace('Boys ','',$cat1);
$cat1 = str_replace('Girls ','',$cat1);
$cat1 = str_replace('Infants/Toddlers ','',$cat1);
      
//Get Type...
$prod_81_cat_2 = $td->product_81_store_category_2;
$gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_2 . "'";
$gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
$gcr = mysqli_fetch_array($gcg);
$cat2 = $gcr['name'];
$cat2 = str_replace('Womens ','',$cat2);
$cat2 = str_replace('Mens ','',$cat2);
$cat2 = str_replace('Boys ','',$cat2);
$cat2 = str_replace('Girls ','',$cat2);
$cat2 = str_replace('Infants/Toddlers ','',$cat2);

//Get Category...
$prod_81_cat_3 = $td->product_81_store_category_3;
$gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_3 . "'";
$gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
$gcr = mysqli_fetch_array($gcg);
$raw_store_category_text = $gcr['name'];
$cat3 = $gcr['name'];
$cat3 = str_replace('Womens ','',$cat3);
$cat3 = str_replace('Mens ','',$cat3);
$cat3 = str_replace('Boys ','',$cat3);
$cat3 = str_replace('Girls ','',$cat3);
$cat3 = str_replace('Infants/Toddlers ','',$cat3);

//Get Sub-Category...
$prod_81_cat_4 = $td->product_81_store_category_4;
$gcq = "SELECT * FROM `oc_category_description` WHERE `category_id` = '" . $prod_81_cat_4 . "'";
$gcg = mysqli_query($s_conn, $gcq) or die($s_conn->error);
$gcr = mysqli_fetch_array($gcg);
$raw_store_category_text = $gcr['name'];
$cat4 = $gcr['name'];
$cat4 = str_replace('Womens ','',$cat4);
$cat4 = str_replace('Mens ','',$cat4);
$cat4 = str_replace('Boys ','',$cat4);
$cat4 = str_replace('Girls ','',$cat4);
$cat4 = str_replace('Infants/Toddlers ','',$cat4);
//Push Category Tags...
array_push($tags_array,$td->product_section,$cat1,$cat2,$cat3,$cat4);

//Product Details...
$product_brand = $td->product_brand;
$product_material = $td->product_material;
$product_color = $td->product_color;
$product_size = $td->product_Size;
//Push Required Item Specific Tags...
array_push($tags_array,'Brand_' . $product_brand);
array_push($tags_array,'Material_' . $product_material);
array_push($tags_array,'Color_' . $product_color);
array_push($tags_array,'Size_' . $product_size);
//optionals...
$product_size_type = $td->product_Size_Type;
if($product_size_type != ''){
  array_push($tags_array,'Size_Type_' . $product_size_type);
}
$product_style = $td->product_Style;
if($product_style != ''){
  array_push($tags_array,'Style_' . $product_style);
}
$product_sleevelength = $td->product_sleevelength;
if($product_sleevelength != ''){
  array_push($tags_array,'Sleevelength_' . $product_sleevelength);
}
$product_Type = $td->product_Type;
if($product_Type != ''){
  array_push($tags_array,'Type_' . $product_Type);
}
$product_Inseam = $td->product_Inseam;
if($product_Inseam != ''){
  array_push($tags_array,'Inseam_' . $product_Inseam);
}

/*$is_array = explode(',',$td->item_specifics_array);
foreach($is_array as $is){
    if($td['product_'.$is] != ''){
      array_push($tags_array,$is . '_' . $td['product_'.$is]);
    }
}*///These Item Specifics need additional coding for pulling out the data points from the object given...

$tags = implode(',',$tags_array);

//Setup POST Data...
$product = array('id' => $product_id,'tags' => $tags);
$post_data = array('product' => $product);
//echo json_encode($post_data, JSON_PRETTY_PRINT);
//die();
#Main Functions...
//Create cURL resource.
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'X-Shopify-Access-Token: ' . $_SESSION['shopify_access_token'],
    'Content-Type: application/json'
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));

//The output string from execution
$output = curl_exec($ch);
$x = json_decode($output);

// close curl resource to free up system resources
curl_close($ch);

//Update product in the database...
$uq = "UPDATE `upc_search_log` SET `shopify_tagged` = 'Yes', `shopify_tagged_time` = CURRENT_TIMESTAMP WHERE `upc_code` = '" . $upc_code . "'";
mysqli_query($conn, $uq) or die($conn->error);

//Setup Response Output...
$x->response = 'GOOD';
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;