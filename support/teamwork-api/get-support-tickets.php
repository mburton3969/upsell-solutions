<?php
/*
* Gather All data for the tickets with this script...
* Loop through the tickets and then do sub cURL Requests for the individual Ticket info to make this simpler...
*/
header('Content-Type: application/json');
error_reporting(0);
//Load Variables...
$inboxID = $_REQUEST['inboxID'];
$pageNum = $_REQUEST['pageNum'];
if($pageNum == ''){
  $pageNum = '1';
}
$api_key = 'tkn.v1_OTNkOTk5MWItYzM3MS00NWNlLTg5M2ItNzg3YzQ2N2M4OGI0LTUxOTI0MC4yMzM3NDMuVVM=';
$endPoint = 'tickets.json?includes=customers,ticketstatuses,users,priorities,types&pageSize=500&page=' . $pageNum;


$url = 'https://ignitioninnovations.teamwork.com/desk/api/v2/' . $endPoint;
//echo $url;
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
    $x->response = 'GOOD';
    $x->request_url = $url;
    $x->pagination = $twData->pagination;
    //$x->ticket_data = $twData;
    $x->tickets = [];
    $i = 0;
    foreach($twData->tickets as $t){
      $d = '';
      if($t->inbox->id == (int)$inboxID){

        $d->ticket_id = $t->id;
        $d->subject = $t->subject;
        $d->preview = $t->previewText;
        $d->created_date = date("m/d/y \n h:iA",strtotime($t->createdAt));
        $d->updated_date = date("m/d/y \n h:iA",strtotime($t->updatedAt));
        $d->state = $t->state;
        $d->customer_id = $t->customer->id;
        $d->customer_name = 'Unknown';
        $d->customer_email = '';
        foreach($twData->included->customers as $customers){
          if($customers->id == $t->customer->id){
            $d->customer_name = $customers->firstName . ' ' . $customers->lastName;
            $d->customer_email = $customers->email;
          }
        }
        
        $d->ticket_status = 'Unknown';
        foreach($twData->included->ticketstatuses as $status){
          if($status->id == $t->status->id){
            if($status->name == 'Active'){
              $status->name = 'Pending';
            }
            $d->ticket_status = $status->name;
          }
        }
        
        $d->agent = 'Not Assigned';
        $d->agent_img = '';
        foreach($twData->included->users as $users){
          if($users->id == $t->agent->id){
            $d->agent = $users->firstName . ' ' . $users->lastName;
            $d->agent_img = $users->avatarURL;
          }
        }
        
        $d->priority = 'unspecified';
        $d->priority_bg = '';
        foreach($twData->included->ticketpriorities as $p){
          if($p->id == $t->priority->id){
            $d->priority = $p->name;
            $d->priority_bg = $p->color;
          }
        }
        
        $d->ticket_type = 'Unknown';
        foreach($twData->included->tickettypes as $p){
          if($p->id == $t->type->id){
            $d->ticket_type = $p->name;
          }
        }

      }
      if($d->ticket_status != 'Closed' && $d->ticket_status != 'Solved'){
        array_push($x->tickets,$d);
        $i++;
      }
    }
    
    
    //echo $twData->tickets[0]->subject;
    
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