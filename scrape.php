<?php

include ('vendor/autoload.php');

$client = new \Goutte\Client();
//$client = \Symfony\Component\Panther\Client::createChromeClient();
$crawler = $client->request('GET', 'https://brickseek.com/products/?search=490770335943');
$fullPageHtml = $crawler->html();
$title = $crawler->filter('.item-list__title')->text();
$price = $crawler->filter('.typography-font-size-notice')->text();
$img = $crawler->filter('.item-list__image-container img')->eq(0)->attr('src');

echo $title;
echo '<br>';
echo $price;
echo '<br>';
echo $img;

/*use Goutte\Client;
$client = new Client();

use Symfony\Component\DomCrawler\Crawler;
$crawler = $client->request('GET', 'https://brickseek.com/products/?search=490770335943');

echo $crawler->filter('.item-list__image-container img')->eq(0)->attr('src');*/
// Output: Image source