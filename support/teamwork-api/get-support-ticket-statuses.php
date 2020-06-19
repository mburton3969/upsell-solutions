<?php
header('Content-Type: application/json');
//Load Variables...
$api_key = 'tkn.v1_OTNkOTk5MWItYzM3MS00NWNlLTg5M2ItNzg3YzQ2N2M4OGI0LTUxOTI0MC4yMzM3NDMuVVM=';
$endPoint = 'ticketstatuses.json';


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
    
    $r = json_encode($twData,JSON_PRETTY_PRINT);
    echo $r;
    
  }else{
    
    echo 'FATAL FAILURE. PLEASE CONTACT SUPPORT!';
    
  }
}else{
  
  echo 'FAILED';
  var_dump($pakmsData);
  
}