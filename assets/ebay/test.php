<?php
$itemID = '283861938119';
$url = "http://beta.reseller-solutions.com/assets/ebay/get-ebay-listing-weight-by-id.php?iid=" . $itemID;
//$iw = file_get_contents($url);

$ch = curl_init($url); // such as http://example.com/example.xml
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

echo $url . '<br>';
echo $data . '<br>';
var_dump($data);
