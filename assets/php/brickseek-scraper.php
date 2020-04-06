<?php
error_reporting(0);
include ('../../vendor/autoload.php');

//Load Variables...
$upc_code = $_GET['upc'];

$client = new \Goutte\Client();
//$client = \Symfony\Component\Panther\Client::createChromeClient();
$crawler = $client->request('GET', 'https://brickseek.com/products/?search=' . $upc_code);
$fullPageHtml = $crawler->html();
$title = $crawler->filter('.item-list__title')->text();
$price = $crawler->filter('.typography-font-size-notice')->text();
$img_url = $crawler->filter('.item-list__image-container img')->eq(0)->attr('src');

// Test if price string contains the word "MSRP", then format accordingly...
$word = 'MSRP';
if(strpos($price, $word) !== false){
    //echo "Word Found!";
  $price = str_replace('MSRP: $','',$price);
} else{
    //echo "Word Not Found!";
}

$x->title = $title;
$x->price = $price;
$x->img_url = $img_url;
  
$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;