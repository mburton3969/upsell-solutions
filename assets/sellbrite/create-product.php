<?php
header('Content-Type: application/json');
error_reporting(0);
include '../php/connection.php';
$s_conn = mysqli_connect('localhost','outfitte_store','+F%JW[$YDOR(','outfitte_opencart') or die('Error: ' . $s_conn->error . ' on line 4 of add-to-store-api.php');

//Load Variables...
$product_code = $_REQUEST['product_code'];
/*if($product_code[0] == '0'){
  $product_code = substr($product_code,1);
}*/
$config = require 'config.php';
$account_token = $config['account_token'];
$secret_key = $config['secret_key'];
$url = 'https://api.sellbrite.com/v1/products/' . $product_code;

//Load Form Variables...
$product_title = $_REQUEST['product_title'];

$pd = $_REQUEST['product_description'];
$pd_extra = $_REQUEST['product_description_extra'];
$pd_footer = $_REQUEST['product_description_footer'];
$fpd = '<p>' . $pd . '</p><p>' . $pd_extra . '</p><p>' . $pd_footer . '</p>';
$wfpd = '<p>' . $pd . '</p><p>' . $pd_extra . '</p>';
$product_description = nl2br($fpd);
$website_product_description = nl2br($wfpd);
//$product_description = nl2br($_REQUEST['product_description']);

//Product Details...
$product_brand = $_REQUEST['product_brand'];
$product_color = $_REQUEST['product_color'];
$product_size_type = $_REQUEST['product_Size_Type'];
$product_style = $_REQUEST['product_Style'];
$product_sleevelength = $_REQUEST['product_sleevelength'];
$product_material = $_REQUEST['product_material'];
$product_size = $_REQUEST['product_Size'];
$product_Type = $_REQUEST['product_Type'];
$product_Inseam = $_REQUEST['product_Inseam'];

$product_label = $_REQUEST['product_label'];
$website_product_title = $product_brand . ' ' . $product_title . ' - ' . $product_size;
if($_REQUEST['product_Inseam'] != ''){
  $website_product_title .=  'x' . $product_Inseam;
}
if($_REQUEST['product_Cup_Size'] != ''){
  $website_product_title .= $_REQUEST['product_Cup_Size'];
}

//$product_category = $_REQUEST['product_category'];
$product_section = $_REQUEST['product_section'];
$product_category = $_REQUEST['cur_cat'];
$product_store_category = $_REQUEST['cur_store_cat'];
$prod_81_cat = $_REQUEST['cur_81_cat'];
$product_81_store_category = $_REQUEST['product_81_store_category_' . $prod_81_cat];
$prod_81_cat_1 = $_REQUEST['product_81_store_category_1'];
$prod_81_cat_2 = $_REQUEST['product_81_store_category_2'];
$prod_81_cat_3 = $_REQUEST['product_81_store_category_3'];
$prod_81_cat_4 = $_REQUEST['product_81_store_category_4'];


$product_condition = $_REQUEST['product_condition'];
if($product_condition == '3000'){
  $product_condition = 'used';
}else{
  $product_condition = 'new';
}

//Images...
$product_image1 = $_REQUEST['img_url1'];
$product_image2 = $_REQUEST['img_url2'];
$product_image3 = $_REQUEST['img_url3'];
$product_image4 = $_REQUEST['img_url4'];
$product_image5 = $_REQUEST['img_url5'];

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
  

$product_price = $_REQUEST['product_price'];
$website_product_price = $_REQUEST['website_product_price'];
$product_msrp = $_REQUEST['product_msrp'];
$product_quantity = $_REQUEST['product_quantity'];

//Package Dimensions...
//$product_pkg_width = $_REQUEST['product_pkg_width'];
//$product_pkg_length = $_REQUEST['product_pkg_length'];
//$product_pkg_depth = $_REQUEST['product_pkg_depth'];
$product_pkg_width = '11';
$product_pkg_length = '14';
$product_pkg_depth = '2';

//Package Weight...
$product_pkg_lbs = $_REQUEST['product_pkg_lbs'];
$product_pkg_oz = $_REQUEST['product_pkg_oz'];
$oz_to_lbs = ($product_pkg_oz / 16);
$pkg_weight = ($product_pkg_lbs + $oz_to_lbs);
//check if under or over 1 pound...
if($pkg_weight <= 1){
    $shipping_service_option = 'USPSFirstClass';
}else{
    $shipping_service_option = 'USPSPriority';
}


$ebay_title = $product_section . ' ' . $product_brand . ' ' . $product_title . ' ' . $product_color . ' ' . $product_size;
if($product_Inseam != ''){
  $ebay_title .= 'x' . $product_Inseam;
}
if($_REQUEST['product_Cup_Size'] != ''){
  $ebay_title .= $_REQUEST['product_Cup_Size'];
}

//Custom Attributes...
$custom_attributes = array();
//$custom_attributes["Brand"] = $product_brand;
$custom_attributes["Material"] = $product_material;
$custom_attributes["Color"] = $product_color;
$custom_attributes["Size"] = $product_size;
$custom_attributes["Inseam"] = $product_Inseam;
$custom_attributes["Type"] = $product_Type;

/*if($product_section == 'Mens'){
  $specific = new Types\NameValueListType();
  $specific->Name = 'Size (Men\'s)';
  $specific->Value[] = $product_size;
  $item->ItemSpecifics->NameValueList[] = $specific;
}elseif($product_section == 'Womens'){
  $specific = new Types\NameValueListType();
  $specific->Name = 'Size (Women\'s)';
  $specific->Value[] = $product_size;
  $item->ItemSpecifics->NameValueList[] = $specific;
}*/

$is_array = explode(',',$_REQUEST['item_specifics_array']);
foreach($is_array as $is){
    if($_REQUEST['product_'.$is] != ''){
      $key = str_replace('_',' ',$is);
      $value = $_REQUEST['product_'.$is];
      $custom_attributes[$key] = $value;
      //array_push($custom_attributes, array($key => $value,));
    }
}

//Setup variables for tag printing...
//Setup Labels for Printing...
$label_original_price = number_format($product_msrp,2);
$label_current_price = number_format($product_price,2);
$label_upc_code = $product_code;
$label_ebay_title = wordwrap($ebay_title,30,"\n");
$label_website_title = wordwrap($website_product_title,30,"\n");
$tag_size = $product_size;
if($_REQUEST['product_Inseam'] != ''){
  $tag_size .= 'x' . $product_Inseam;
}
if($_REQUEST['product_Cup_Size'] != ''){
  $tag_size .= $_REQUEST['product_Cup_Size'];
}

$hang_tag_data = array(
  'label_original_price' => $label_original_price,
  'label_current_price' => $label_current_price,
  'label_upc_code' => $label_upc_code,
  'label_ebay_title' => $label_ebay_title,
  'label_website_title' => $label_website_title,
  'tag_size' => $tag_size
);

/*
//Category Field...
//Get Gender...
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

$final_category = $cat1 . ' ' . $cat2 . ' ' . $cat3 . ' ' . $cat4;*/

$final_category = '';
if($_REQUEST['product_category_1']){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $_REQUEST['product_category_1'] . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= $r['category_name'];
}

if($_REQUEST['product_category_2']){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $_REQUEST['product_category_2'] . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= ' > ' . $r['category_name'];
}

if($_REQUEST['product_category_3']){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $_REQUEST['product_category_3'] . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= ' > ' . $r['category_name'];
}

if($_REQUEST['product_category_4']){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_id` = '" . $_REQUEST['product_category_4'] . "'";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $r = mysqli_fetch_array($g);
  $final_category .= ' > ' . $r['category_name'];
}

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



#Main Functions...

//Create Product Object...
$product = array(
  "condition" => $product_condition,
  "package_unit_of_length" => "inches",
  "package_unit_of_weight" => "pounds",
  "image_list" => $img_array,
  "name" => $product_title,
  "brand" => $product_brand,
  "manufacturer" => $product_brand,
  "description" => $website_product_description,
  "price" => $product_price,
  "msrp" => $product_msrp,
  "category_name" => $final_category,
  "upc" => $product_code,
  "package_length" => $product_pkg_length,
  "package_width" => $product_pkg_width,
  "package_height" => $product_pkg_depth,
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
  $x->hang_tag_data = $hang_tag_data;
}

//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;