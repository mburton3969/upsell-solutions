<?php
header('Content-Type: application/json');
error_reporting(0);
include '../php/connection.php';

//Load Variables...
$trip = false;
$upc = $_REQUEST['upc'];
$source = $_REQUEST['src'];

$de_apikey = '/4elLY%2BpIk2S';//Live Account

$auth_key = 'Ws05M3r7w9Bt3Yu1';//Live Account

$bl_apikey = 'nvr38f3cdml6nlwjqqa3vx21cbbrqn';

$ud_apikey = '2e514306059046cf75e01e0010bce0ee';

$wm_apikey = 'rfjbc7str5mjyf6ta4ed76jf';

$qs = '&de_apikey=' . $de_apikey . '&auth_key=' . $auth_key . '&bl_apikey=' . $bl_apikey . '&ud_apikey=' . $ud_apikey . '&wm_apikey=' . $wm_apikey;
//Loop Through UPC Codes in Database...
/*$q = "SELECT * FROM `upc_codes` WHERE `inactive` != 'Yes' LIMIT 1";
$g = mysqli_query($conn, $q) or die($conn->error);
while($r = mysqli_fetch_array($g)){*/
  
  
  //$upc = '035000521019';
  $lu_url = 'http://' . $_SERVER['HTTP_HOST'] . '/assets/php/upc-lookup.php?upc=' . $upc . '&scrape=Yes' . $qs;
  //echo $lu_url;
  //break;
  $data = file_get_contents($lu_url);
  $data = json_decode($data);
  $x = '';
  
  $x->lookup_url = $lu_url;
  //Decode the Response Data from UPC-Lookup.php...
  if($data->bl_data != false){
    
    $d = json_decode($data->bl_data);
    $d = $d->products[0];
    $x->response = 'GOOD';
    $x->message = 'UPC Code Found!';
    $x->data_source = 'barcodelookup.com';
    $x->title = $d->product_name;
    $x->description = $d->description;
    $x->brand = $d->manufacturer;
    $x->color = $d->color;
    $x->size = $d->size;
    $x->weight = $d->weight;
    $x->img1 = $d->images[0];
    $x->img2 = $d->images[1];
    $x->img3 = $d->images[2];
    $x->img4 = $d->images[3];
    $x->img5 = $d->images[4];
    $res = json_encode($x);
    echo $res;
    //print_r($d);
    //break;
    
  }elseif($data->de_data != false){
    
    $d = json_decode($data->de_data);
    $x->response = 'GOOD';
    $x->message = 'UPC Code Found!';
    $x->data_source = 'digit-eyes.com';
    $x->title = $d->description;
    $x->description = $d->description;
    $x->brand = $d->brand;
    $x->img1 = $d->image;
    $res = json_encode($x);
    echo $res;
    //print_r($d);
    //break;
    
  }elseif($data->upc_data != false){
    
    $d = json_decode($data->upc_data);
    $x->response = 'GOOD';
    $x->message = 'UPC Code Found!';
    $x->data_source = 'upcitemdb.com';
    //Get item data...
    $i = $d->items[0];
    $x->title = $i->title;
    $x->description = $i->description;
    $x->brand = $i->brand;
    $x->color = $i->color;
    $x->size = $i->size;
    $x->weight = $i->weight;
    //Get item images...
    $x->img1 = $i->images[0];
    $x->img2 = $i->images[1];
    $x->img3 = $i->images[2];
    $x->img4 = $i->images[3];
    $x->img5 = $i->images[4];
    //echo 'upc_data -> ';
    //print_r($d);
    $res = json_encode($x);
    echo $res;
    //break;
    
  }elseif($data->wm_data != false){
    
    $d = json_decode($data->wm_data);
    $x->response = 'GOOD';
    $x->message = 'UPC Code Found!';
    $x->data_source = 'walmart.com';
    //Get item data...
    $i = $d->items[0];
    $x->title = $i->name;
    $x->description = $i->shortDescription;
    $x->brand = $i->brandName;
    $x->color = $i->color;
    $x->size = $i->size;
    $x->price = number_format($i->salePrice,2);
    //Get item images...
    $x->img1 = $i->imageEntities[0]->largeImage;
    $x->img2 = $i->imageEntities[1]->largeImage;
    $x->img3 = $i->imageEntities[2]->largeImage;
    $x->img4 = $i->imageEntities[3]->largeImage;
    $x->img5 = $i->imageEntities[4]->largeImage;
    //echo 'wm_data -> ';
    $res = json_encode($x);
    echo $res;
    //break;
    
  }elseif($data->bs_data != false){
    
    $d = json_decode($data->bs_data);
    $x->response = 'GOOD';
    $x->message = 'UPC Code Found!';
    $x->data_source = 'brickseek.com';
    $x->title = $d->title;
    $x->brand = $d->brand;
    $x->color = $d->color;
    $x->size = $d->size;
    $x->price = $d->price;
    $x->weight = $d->weight;
    $x->img1 = $d->img_url;
    //echo 'bs_data -> ';
    $res = json_encode($x);
    echo $res;
    //break;
    
  }elseif($data->di_data != false){
    
    $d = json_decode($data->di_data);
    $p = $d->data->records[0];
    $x->response = 'GOOD';
    $x->message = 'UPC Code Found!';
    $x->data_source = 'DataInfiniti.com';
    $x->title = $p->name;
    $x->brand = $p->brand;
    $x->color = $p->colors[0];
    $x->size = $p->size;
    //$x->price = $p->price;
    //$x->weight = $p->weight;
    //Get item images...
    $x->img1 = $p->imageURLs[0];
    $x->img2 = $p->imageURLs[1];
    $x->img3 = $p->imageURLs[2];
    $x->img4 = $p->imageURLs[3];
    $x->img5 = $p->imageURLs[4];
    $res = json_encode($x);
    echo $res;
    
  }elseif($source == 'Target'){
    $iq = "SELECT * FROM `upc_codes` WHERE `upc_code` = '" . $upc . "'";
    $ig = mysqli_query($conn, $iq) or die($conn->error);
    $ir = mysqli_fetch_array($ig);
      $nTitle = explode(' - ',$ir['item_description']);
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
    
      $x->data_source = 'Target Manifest';
      $x->title = $title;
      $x->brand = $brand;
      $x->size = $nodes2[$iSize];
      $x->color = trim($color);
      $x->price = $price;
    
    $res = json_encode($x);
    echo $res;
    
  }else{
    $x->response = 'ERROR';
    $x->message = 'No Data Found for UPC Code ' . $upc;
    $res = json_encode($x);
    echo $res;
    $x->data_source = 'ERROR';
    //echo 'UPC ' . $upc . ' not found! -> ';
    $trip = true;
  }
  

//}//End MySQLi While Loop...

?>