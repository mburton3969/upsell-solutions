<?php
header('Content-Type: application/json');
error_reporting(0);
include ('../../vendor/autoload.php');

//Load Variables...
$upc_code = $_GET['upc'];
$client = new \Goutte\Client();
//$client = \Symfony\Component\Panther\Client::createChromeClient();

//Check main brickseek search...
$crawler = $client->request('GET', 'https://brickseek.com/products/?search=' . $upc_code);
//$fullPageHtml = $crawler->html();

//Check if results are found...
$itemFound = true;
if($crawler->filter('.message__body')->count() > 0){
  if($crawler->filter('.message__body')->text() == 'No products found for your selected filters. Please broaden your search or try again later.'){
    $itemFound = false;
  }
}else{
  $itemFound = true;
}

if($itemFound != true){

  $x->source = 'Main Search';
  $rtitle = $crawler->filter('.item-list__title')->text();
  //$price = $crawler->filter('.typography-font-size-notice')->text();
  $price = '';
  $img_url = $crawler->filter('.item-list__image-container img')->eq(0)->attr('src');
  //echo $rtitle;
}else{
  
  $x->source = 'Walmart Inventory Checker';
  $crawler = $client->request('GET', 'https://brickseek.com/walmart-inventory-checker/');
  $form = $crawler->filter('.inventory-checker-form')->form();
  $form['method']->select('upc');
  $form['upc'] = $upc_code;
  $crawler = $client->submit($form);
  
  $rtitle = $crawler->filter('.item-overview__title')->text();
  $img_url = $crawler->filter('.item-overview__image-wrap img')->eq(0)->attr('src');
  $wm_url = $crawler->filter('.item-overview__actions-item')->eq(1)->attr('href');
  
  $crawler = $client->request('GET', $wm_url);
  $img2 = $crawler->filter('.hover-zoom-hero-image')->eq(0)->attr('src');
  $brand = $crawler->filter('.prod-brandName > span')->text();
  $title = $crawler->filter('.prod-ProductTitle')->text();
  //$description = $crawler->filter('.about-desc > .about-product-description')->html();
  
  $x->title = $title;
  $x->brand = $brand;
  $x->description = $description;
  $res = json_encode($x);
  echo $res;
}

  //Formatting...

  // Test if price string contains the word "MSRP", then format accordingly...
  /*$word = 'MSRP';
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
echo $response;*/

