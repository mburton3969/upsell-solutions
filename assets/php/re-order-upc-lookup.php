<?php


$trip = false;
$x->mess = 'Message - de_data Searched';
$x->de_data = file_get_contents($de_url);
$de_json = json_decode($x->de_data);
if($de_json->return_code == 4){
  $x->de_data = false;
}
if($x->de_data == false && $trip != true){
  $x->mess .= ' - bl_data Searched';
  $x->bl_data = file_get_contents($bl_url);
  if($x->bl_data == '' || $x->bl_data == null){
    $x->bl_data = false;
  }
}else{
  $x->bl_data = false;
  $trip = true;
}
if($x->bl_data == false && $trip != true){
  $x->mess .= ' - upc_data Searched';
  $x->upc_data = file_get_contents($upc_url);
  if($x->upc_data->total == 0){
    $x->upc_data = false;
  }
}else{
  $x->upc_data = false;
  $trip = true;
}
if($x->upc_data == false && $trip != true){
  $x->mess .= ' - wm_data Searched';
  $x->wm_data = file_get_contents($wm_url);
}else{
  $x->wm_data = false;
  $trip = true;
}


?>