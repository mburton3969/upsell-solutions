<?php
include 'connection.php';

//Load Variables...
$level = $_GET['level'];
$pid = $_GET['pid'];

//Get Categories...
if($level == '1'){
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_level` = '" . $level . "' ORDER BY `category_name` ASC";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $i = 0;
  while($r = mysqli_fetch_array($g)){
    $x->cat[$i] = new stdClass;
    $x->cat[$i]->name = $r['category_name'];
    $x->cat[$i]->id = $r['category_id'];
    $i++;
  }
  $response = json_encode($x);
  echo $response;
}else{
  $q = "SELECT * FROM `ebay_categories` WHERE `inactive` != 'Yes' AND `category_level` = '" . $level . "' AND `parent_id` = '" . $pid . "' ORDER BY `category_name` ASC";
  $g = mysqli_query($conn, $q) or die($conn->error);
  $i = 0;
  while($r = mysqli_fetch_array($g)){
    $x->cat[$i] = new stdClass;
    $x->cat[$i]->name = $r['category_name'];
    $x->cat[$i]->id = $r['category_id'];
    $i++;
  }
  $response = json_encode($x);
  echo $response;
}


?>