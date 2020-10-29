<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();

//Load Variables...
$config = require 'config.php';
$api_key = $config['api_key'];
$api_secret_key = $config['api_secret_key'];
$api_version = $config['api_version'];
$shop = $config['shop'];
$resource = 'products';
$pagination_link = $_REQUEST['pagination_link'];
$page_info = $_REQUEST['page_info'];
if($_REQUEST['page_info']){
  $url = 'https://' . $shop . '.myshopify.com/admin/api/' . $api_version . '/' . $resource . '.json?limit=250&page_info=' . $page_info;
}else{
  $url = 'https://' . $shop . '.myshopify.com/admin/api/' . $api_version . '/' . $resource . '.json?limit=250';
}

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
curl_setopt($ch, CURLOPT_HEADER, 1);
//The output string from execution
$output = curl_exec($ch);

//Parse response header...
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($output, 0, $header_size);
$body = substr($output, $header_size);

$x = json_decode($body);

// close curl resource to free up system resources
curl_close($ch);

$headers = explode("\r\n", $headers);
$link;
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
foreach($headers as $h){
  if(strpos($h,'link:') !== false){
    $link = str_replace('link: ','',$h);
    if((strpos($link,'rel="previous"') !== false) && (strpos($link,'rel="next"') === false)){
      $link = '';
    }else{
      if(strpos($link,'rel="previous", <') !== false){
        $link = get_string_between($link, 'rel="previous", <', '>');
      }else{
        $link = get_string_between($link, '<', '>');
      }
      $link = explode('?',$link);
      $link = $link[1];
      $link = explode('&page_info=',$link);
      $link = $link[1];
    }
  }
}
//echo $link;
//print_r($headers);
//die();
$x->pagination_link = $link;
$x->response = 'GOOD';
//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;