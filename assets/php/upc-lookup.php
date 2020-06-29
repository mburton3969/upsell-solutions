<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
include 'connection.php';
#
# Digit Eyes Code to Generate and Output JSON
#
#****Dynamic UPC from form****
$upc_code = $_GET['upc'];

#****Substitute Your Auth Key****
$auth_key = $_GET['auth_key'];
$auth_key = str_replace('/','%2F',$auth_key);

#****Substitute Your App Key****
$de_app_key = $_GET['de_apikey'];
$de_app_key = str_replace('/','%2F',$de_app_key);

$bl_app_key = $_GET['bl_apikey'];

$wm_app_key = $_GET['wm_apikey'];

#****Generates API Signature****
$signature = base64_encode(hash_hmac('sha1', $upc_code, $auth_key, $raw_output = true));
$signature = str_replace('/','%2F',$signature);

$bs_url = 'https://' . $_SERVER['HTTP_HOST'] . '/assets/php/brickseek-scraper.php?upc=' . $upc_code;

$de_url = 'https://digit-eyes.com/gtin/v2_0/?upcCode='. $upc_code .'&app_key='. $de_app_key .'&language=en&field_names=all&signature='. $signature;

$bl_url = 'https://api.barcodelookup.com/v2/products?barcode=' . $upc_code . '&formatted=y&key=' . $bl_app_key;

$upc_url = 'https://api.upcitemdb.com/prod/trial/lookup?upc=' . $upc_code;

$wm_url = 'http://api.walmartlabs.com/v1/items?apiKey=rfjbc7str5mjyf6ta4ed76jf&upc=' . $upc_code;

//Data Response Variables...
$x->ra_data = false;
$x->bs_data = false;
$x->de_data = false;
$x->bl_data = false;
$x->upc_data = false;
$x->wm_data = false;

//API Search Link URLs...
$x->bs_url = $bs_url;
$x->de_url = $de_url;
$x->wm_url = $wm_url;
$x->upc_url = $upc_url;
$x->bl_url = $bl_url;

//Set the Trip Variable to false...
$trip = false;
//Set Data Source to NONE...
$data_source = 'NONE';

$x->mess = 'Message';

$upcq = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' AND `upc_code` = '" . $upc_code . "'";
$upcg = mysqli_query($conn, $upcq) or die($conn->error);
$sdq = "SELECT * FROM `upc_search_log` WHERE `upc_code` = '" . $upc_code . "' AND (`log_type` = 'Listing_Ebay' OR `log_type` = 'Listing_Store') AND `request_data` != '' LIMIT 1";
$sdg = mysqli_query($conn, $sdq) or die($conn->error);
if(mysqli_num_rows($upcg) > 0 && $_REQUEST['scrape'] != 'Yes' && mysqli_num_rows($sdg) <= 0){
  $upcr = mysqli_fetch_array($upcg);
  //UPC Found...
  if($upcr['accurate'] == 'No'){
    $d->upc = $upcr['upc_code'];
    $d->description = htmlentities($upcr['item_description']);
    $d->long_description = '';
    $d->brand = '';
    $d->size = '';
    $d->color = '';
    $d->img1 = '';
    $d->img2 = '';
    $d->img3 = '';
    $d->img4 = '';
    $d->img5 = '';
    $d->price = '';
    $d->weight = '';
    $d->accurate = $upcr['accurate'];
  }else{
    $d->upc = $upcr['upc_code'];
    $d->title = $upcr['item_title'];
    $d->description = htmlentities($upcr['item_description']);
    $d->long_description = htmlentities($upcr['long_description']);
    $d->brand = $upcr['brand'];
    $d->size = $upcr['size'];
    $d->color = $upcr['color'];
    $d->img1 = $upcr['img1'];
    $d->img2 = $upcr['img2'];
    $d->img3 = $upcr['img3'];
    $d->img4 = $upcr['img4'];
    $d->img5 = $upcr['img5'];
    $d->price = $upcr['retail_price'];
    $d->weight = $upcr['item_weight'];
    $d->accurate = $upcr['accurate'];
  }
  $x->ra_data = json_encode($d);
  $data_source = 'Reseller App';
  $trip = true;
  $x->mess = 'Message - ra_data Searched';
  echo $ej;
}elseif(mysqli_num_rows($sdg) > 0 && $_REQUEST['scrape'] != 'Yes'){
  $sdr = mysqli_fetch_array($sdg);
  $d->source = 'upc_search_log DB';
  $r = json_decode($sdr['request_data']);
  foreach($r as $key => $value){
    $d->$key = $value;
  }
  $x->ra_data = json_encode($d);
  $data_source = 'Reseller App';
  $trip = true;
  $x->mess = 'Message - ra_data Searched';
}else{
  $x->ra_data = false;
}

if($x->ra_data == false && $trip == false){

//Check BarcodeLookup.com...
$x->mess .= ' - bl_data Searched';
$x->bl_data = file_get_contents($bl_url);
if($x->bl_data == '' || $x->bl_data == null || $upc_code == '035000521019' || $upc_code == '883096536116'){
  $x->debug = 'Triggered';
  $x->bl_data = false;
}

//Check Digit-Eyes.com...
if($x->bl_data == false && $trip != true){
  $x->mess .= ' - de_data Searched';
  $x->de_data = file_get_contents($de_url);
  $de_json = json_decode($x->de_data);
  if($de_json->return_code == 4 || $de_json->return_code == '001' || $upc_code == '035000521019'){
    $x->de_data = false;
  }
}else{
  $x->de_data = false;
  if($trip != true){
    $trip = true;
    $data_source = 'barcodelookup.com';
  }
}

//Check UPCscan.com...
if($x->de_data == false && $trip != true){
  $x->mess .= ' - upc_data Searched';
  $x->upc_data = file_get_contents($upc_url);
  $jd = json_decode($x->upc_data);
  if($x->upc_data != false && $jd->total == 0 || $upc_code == '035000521019'){
    $x->upc_data = false;
  }
}else{
  $x->upc_data = false;
  if($trip != true){
    $trip = true;
    $data_source = 'digit-eyes.com';
  }
}

//Check Walmart.com...
if($x->upc_data == false && $trip != true){
  $x->mess .= ' - wm_data Searched';
  $x->wm_data = file_get_contents($wm_url);
  $rwmd = json_decode($x->wm_data);
  if(!isset($rwmd->items) || $x->wm_data == false){
    $x->wm_data = false;
  }else{
    $data_source = 'walmart.com';
  }
}else{
  $x->wm_data = false;
  if($trip != true){
    $trip = true;
    $data_source = 'upcitemdb.com';
  }
}

//Check BrickSeek.com...
if($x->wm_data == false && $trip != true){
  $x->mess .= ' - bs_data Searched';
  $x->bs_data = file_get_contents($bs_url);
  if($x->bs_data == false){
    $x->bs_data = false;
  }else{
    $data_source = 'brickseek.com';
    $trip = true;
  }
}else{
  $x->bs_data = false;
  if($trip != true){
    $trip = true;
    $data_source = 'walmart.com';
  }
}

}//End if ra_data is false...
/*
$x->bs_data = file_get_contents($bs_url);
$x->de_data = file_get_contents($de_url);
$x->bl_data = file_get_contents($bl_url);
$x->upc_data = file_get_contents($upc_url);
$x->wm_data = file_get_contents($wm_url);
*/

if($trip == false){
  $found = 'No';
  $x->mess .= ' - Found [No]';
}else{
  $found = 'Yes';
  $x->mess .= ' - Found [Yes]';
}
$iq = "INSERT INTO `upc_search_log` 
      (`date`,`time`,`log_type`,`upc_code`,`data_found`,`data_source`,`notes`,`user_id`,`user_name`,`inactive`)
      VALUES
      (CURRENT_DATE,CURRENT_TIME,'UPC Scan','" . mysqli_real_escape_string($conn,$upc_code) . "','" . $found . "','" . $data_source . "','" . $x->mess . "','" . $_SESSION['user_id'] . "','" . $_SESSION['user_name'] . "','No')";
if($_REQUEST['scrape'] != 'Yes'){
  mysqli_query($conn, $iq) or die('Log Error: ' . $conn->error);
}

$data = json_encode($x,JSON_PRETTY_PRINT);

echo $data;

?>