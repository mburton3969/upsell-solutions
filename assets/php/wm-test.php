<?php
header('Content-Type: application/json');
error_reporting(0);

$upc_code = '0883096536116';

$wm_url = 'http://api.walmartlabs.com/v1/items?apiKey=rfjbc7str5mjyf6ta4ed76jf&upc=' . $upc_code;

$rwmd = file_get_contents($wm_url);
$wmd = json_decode($rwmd);
$x->wm_data = json_encode($wmd);

/*
echo 'Object: ' . is_object($wmd);
echo ' -- ';
echo 'Array: ' . is_array($wmd);
echo ' -- ';
echo 'String: ' . is_string($wmd);
*/

//var_dump($wmd);

//$dd = json_decode($wmd->items);
//echo $dd;
//print_r($wmd);

if(isset($wmd->items)){
  echo 'Testing ' . $wmd->items[0]->upc;
}