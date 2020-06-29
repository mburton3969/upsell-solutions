<?php
header('Content-Type: application/json');
error_reporting(0);
//Load Variables...
$api_key = 'tkn.v1_OTNkOTk5MWItYzM3MS00NWNlLTg5M2ItNzg3YzQ2N2M4OGI0LTUxOTI0MC4yMzM3NDMuVVM=';
$endPoint = 'tickets.json?page=7&includes=tags,messages,priorities';


$url = 'https://ignitioninnovations.teamwork.com/desk/api/v2/' . $endPoint;
  
$ch = curl_init();
//set the url
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'authorization: Bearer ' . $api_key
));
  
//execute post
$twData = curl_exec($ch);
if($twData == true){
  $twData = json_decode($twData);
  if($twData->message != '401 Unauthorized'){
    
    //$r = json_encode($twData,JSON_PRETTY_PRINT);
    $x->reponse = 'GOOD';
    $x->ticket_data = $twData;
    
  }else{
    
    $x->response = 'ERROR';
    $x->message = 'FATAL FAILURE. PLEASE CONTACT SUPPORT!';
    
  }
}else{
  
  $x->response = 'ERROR';
  $x->message = 'FAILED';
  
}

$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;