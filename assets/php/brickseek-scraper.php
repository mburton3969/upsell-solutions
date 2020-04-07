<?php
header('Content-Type: application/json');
error_reporting(0);
include ('../../vendor/autoload.php');

//Load Variables...
$upc_code = $_GET['upc'];
$client = new \Goutte\Client();
//$client = \Symfony\Component\Panther\Client::createChromeClient();
$crawler = $client->request('GET', 'https://brickseek.com/products/?search=' . $upc_code);
$fullPageHtml = $crawler->html();
$rtitle = $crawler->filter('.item-list__title')->text();
//$price = $crawler->filter('.typography-font-size-notice')->text();
$price = '';
$img_url = $crawler->filter('.item-list__image-container img')->eq(0)->attr('src');

//Formatting...

// Test if price string contains the word "MSRP", then format accordingly...
$word = 'MSRP';
if(strpos($price, $word) !== false){
    //echo "Word Found!";
  $price = str_replace('MSRP: $','',$price);
} else{
    //echo "Word Not Found!";
}

$nTitle = explode(' - ',$rtitle);
$title = $nTitle[0];
//Node Data Breakdown...
$nodes = preg_split('/[[:^print:]]/', $nTitle[1]);
$brand = trim($nodes[0]);
$nodes = array_values(array_filter($nodes));
$nodes2 = explode(' ',$nodes[1]);
$iSize = count($nodes2) - 1;
$color = '';
for($i = 0; $i <= count($nodes2) - 2; $i++){
  $color .= $nodes2[$i] . ' ';
}

$x->upc = $upc_code;
$x->title = $title;
$x->brand = $brand;
$x->size = $nodes2[$iSize];
$x->color = trim($color);
$x->price = $price;
$x->img_url = $img_url;
$x->raw_title = $rtitle;
$x->nodes = $nodes;

  
$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;
