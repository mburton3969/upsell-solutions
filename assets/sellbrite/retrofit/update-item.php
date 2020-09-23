<?php
header('Content-Type: application/json');
error_reporting(0);
include '../../php/connection.php';



//Load Variables...
$product_code = $_REQUEST['upc_code'];
$pqty = $_REQUEST['qty'];
$config = require '../config.php';
$account_token = $config['account_token'];
$secret_key = $config['secret_key'];
$url = 'https://api.sellbrite.com/v1/products/' . $product_code;


#Main Functions...

//Get Tags from Database...
$tq = "SELECT * FROM `upc_search_log` WHERE `inactive` != 'Yes' AND `log_type` != 'UPC Scan' AND `shopify_tagged` != 'Yes' AND `listed` = 'Yes' AND `upc_code` = '" . $product_code . "' ORDER BY `ID` DESC LIMIT 1";
$tg = mysqli_query($conn, $tq) or die($conn->error);
if(mysqli_num_rows($tg) <= 0){
  $x->response = 'ERROR';
  $x->error = 'No Item found with this UPC Code...';
  $response = json_encode($x, JSON_PRETTY_PRINT);
  echo $response;
  die();
}
$tr = mysqli_fetch_array($tg);
$td = json_decode($tr['request_data']);


$final_category = '';
if($td->product_category_1){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $td->product_category_1 . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= $r['category_name'];
}

if($td->product_category_2){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $td->product_category_2 . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= ' > ' . $r['category_name'];
}

if($td->product_category_3){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $td->product_category_3 . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= ' > ' . $r['category_name'];
}

if($td->product_category_4){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $td->product_category_4 . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= ' > ' . $r['category_name'];
}

//Package Weight...
$product_pkg_lbs = $td->product_pkg_lbs;
$product_pkg_oz = $td->product_pkg_oz;
$oz_to_lbs = ($product_pkg_oz / 16);
$pkg_weight = ($product_pkg_lbs + $oz_to_lbs);

//Apend Weight Prefix to Category...
$weight_prefix = '';
if($pkg_weight >= 1){
  $weight_prefix = '1lb';
}
if($pkg_weight >= 2){
  $weight_prefix = '2lb';
}
if($pkg_weight >= 3){
  $weight_prefix = '3lb';
}
if($pkg_weight >= 4){
  $weight_prefix = '4lb';
}
if($pkg_weight >= 5){
  $weight_prefix = '5lb';
}
if($pkg_weight >= 6){
  $weight_prefix = '6lb';
}
if($pkg_weight >= 7){
  $weight_prefix = '7lb';
}
if($pkg_weight >= 8){
  $weight_prefix = '8lb';
}
if($pkg_weight >= 9){
  $weight_prefix = '9lb';
}
if($pkg_weight >= 10){
  $weight_prefix = '+10lb';
}

if($weight_prefix != ''){
  $final_category = $weight_prefix . ' - ' . $final_category;
}

//Images...
$product_image1 = $td->img_url1;
$product_image2 = $td->img_url2;
$product_image3 = $td->img_url3;
$product_image4 = $td->img_url4;
$product_image5 = $td->img_url5;

$img_array = [];
if($product_image1 != '' && $product_image1 != 'undefined'){
  array_push($img_array, $product_image1);
}
if($product_image2 != '' && $product_image2 != 'undefined'){
  array_push($img_array, $product_image2);
}
if($product_image3 != '' && $product_image3 != 'undefined'){
  array_push($img_array, $product_image3);
}
if($product_image4 != '' && $product_image4 != 'undefined'){
  array_push($img_array, $product_image4);
}
if($product_image5 != '' && $product_image5 != 'undefined'){
  array_push($img_array, $product_image5);
}

//Product Title...
$website_product_title = $td->product_brand . ' ' . $td->product_title . ' - ' . $td->product_Size;
if($td->product_Inseam != ''){
  $website_product_title .=  'x' . $td->product_Inseam;
}
if($td->product_Cup_Size != ''){
  $website_product_title .= $td->product_Cup_Size;
}

//Custom Attributes...
$custom_attributes = array();
//$custom_attributes["Brand"] = $product_brand;
$custom_attributes["Material"] = $td->product_material;
$custom_attributes["Color"] = $td->product_color;
$custom_attributes["Size"] = $td->product_Size;
$custom_attributes["Type"] = $td->product_Type;
if($td->product_Inseam != ''){
  $custom_attributes["Inseam"] = $td->product_Inseam;
}

//Product Section...
$custom_attributes["Section"] = $td->product_section;

/*$is_array = explode(',',$td->item_specifics_array);
foreach($is_array as $is){
    if($_REQUEST['product_'.$is] != ''){
      $key = str_replace('_',' ',$is);
      $value = $_REQUEST['product_'.$is];
      $custom_attributes[$key] = $value;
      //array_push($custom_attributes, array($key => $value,));
    }
}*/

//Descriptions...
$pd = $td->product_description;
$pd_extra = $td->product_description_extra;
$pd_footer = $td->product_description_footer;
$fpd = '<p>' . $pd . '</p><p>' . $pd_extra . '</p><p>' . $pd_footer . '</p>';
$wfpd = '<p>' . $pd . '</p><p>' . $pd_extra . '</p>';
$product_description = nl2br($fpd);
$website_product_description = nl2br($wfpd);

if($td->product_msrp != ''){
  $msrp = $td->product_msrp;
}else{
  $msrp = ($td->website_product_price * 2);
}

$product_condition = $td->product_condition;
if($product_condition == '3000'){
  $product_condition = 'used';
}else{
  $product_condition = 'new';
}

//Create Product Object...
$product = array(
  "condition" => $product_condition,
  "package_unit_of_length" => "inches",
  "package_unit_of_weight" => "pounds",
  "image_list" => $img_array,
  "name" => $website_product_title,
  "brand" => $td->product_brand,
  "manufacturer" => $td->product_brand,
  "description" => $website_product_description,
  "price" => $td->website_product_price,
  "msrp" => number_format($msrp,2),
  "category_name" => $final_category,
  "upc" => $td->product_code,
  "package_length" => 14,
  "package_width" => 11,
  "package_height" => 2,
  "package_weight" => $pkg_weight,
  "custom_attributes" => $custom_attributes
);
//echo json_encode($product,JSON_PRETTY_PRINT);
//die();

// create curl resource
$ch = curl_init();
//Create cURL Headers.
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic '. base64_encode("$account_token:$secret_key")
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//The output string from execution
$output = curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
$x = json_decode($output);
if($x->error){
  $x->response = 'ERROR';
}else{
  $x->response = 'GOOD';
  $x->message = 'Item Updated';
  $x->product_label = $td->product_label;
}

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;