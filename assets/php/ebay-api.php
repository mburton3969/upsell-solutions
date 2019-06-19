<?php
include 'ebay-token.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.ebay.com/buy/browse/v1/item_summary/search');


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization:Bearer ' . $apiToken
));

curl_setopt($ch, CURLOPT_POST, 1);

$post_data = array(
	'category' => '108765',
	'q' => 'Beatles',
	'filter' => 'price:[200..500]',
	'filter' => 'priceCurrency:USD',
	'limit' => '10'
);

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$output = curl_exec($ch);

if($output === FALSE){
	echo 'cURL Error: ' . curl_error($ch);
}


curl_close($ch);

print_r($output);


?>