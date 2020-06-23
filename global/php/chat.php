<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
include 'connection.php';

//Load Variables...
$mode = $_REQUEST['mode'];
$channel_id = $_REQUEST['channel_id'];
$message = mysqli_real_escape_string($conn, $_REQUEST['message']);

#Response Error
$x->response = 'ERROR';
$x->error_message = 'Chat System Error: Mode not detected.';

#Main Functions

//ALL Mode...
if($mode == 'ALL'){
  $x->response = 'GOOD';
  $x->error_message = '';
  $mq = "SELECT * FROM `chat_messages` as `m`
         WHERE `m`.`inactive` != 'Yes' 
         AND `m`.`channel_id` = '" . $channel_id . "'
         ORDER BY `m`.`ID` DESC 
         LIMIT 50";
  $mg = mysqli_query($conn, $mq) or die($conn->error);
  $x->messages = [];
  while($mr = mysqli_fetch_array($mg)){
    $d = '';
    //Check mode...
    if($mr['user_id'] == $_SESSION['user_id']){
      $mMode = 'self';
    }else{
      $mMode = 'friend';
    }
    $d->mode = $mMode;
    $d->message = $mr['message'];
    $d->time = date("m/d/y",strtotime($mr['date'])) . ' @ ' . date("h:i A",strtotime($mr['time']));
    $d->user = $mr['user_name'];
    //Parse for initials...
    $in = explode(' ',$mr['user_name']);
    $d->initials = substr($in[0],0,1) . substr($in[1],0,1);
    //Add message to array...
    array_push($x->messages,$d);
  }
}//End ALL Mode...




//Fetch Mode...
if($mode == 'Fetch'){
  $x->response = 'GOOD';
  $x->error_message = '';
  $mq = "SELECT * FROM `chat_messages` as `m`
         WHERE `m`.`inactive` != 'Yes' 
         AND `m`.`channel_id` = '" . $channel_id . "' 
         AND NOT EXISTS (SELECT 1 FROM `chat_message_views` as `v`
                         WHERE `v`.`message_id` = `m`.`ID`
                         AND `v`.`user_id` = '" . $_SESSION['user_id'] . "')
         ORDER BY `m`.`ID` DESC 
         LIMIT 50";
  $mg = mysqli_query($conn, $mq) or die($conn->error);
  $x->messages = [];
  while($mr = mysqli_fetch_array($mg)){
    $d = '';
    //Check mode...
    if($mr['user_id'] == $_SESSION['user_id']){
      $mMode = 'self';
    }else{
      $mMode = 'friend';
    }
    $d->mode = $mMode;
    $d->message = $mr['message'];
    $d->time = date("m/d/y",strtotime($mr['date'])) . ' @ ' . date("h:i A",strtotime($mr['time']));
    $d->user = $mr['user_name'];
    //Parse for initials...
    $in = explode(' ',$mr['user_name']);
    $d->initials = substr($in[0],0,1) . substr($in[1],0,1);
    //Add message to array...
    array_push($x->messages,$d);
    //Insert View Record...
    $iq = "INSERT INTO `chat_message_views`
           (
           `message_id`,
           `user_id`
           )
           VALUES
           (
           '" . $mr['ID'] . "',
           '" . $_SESSION['user_id'] . "'
           )";
    mysqli_query($conn, $iq) or die($conn->error);
  }
}//End Fetch Mode...



//Add Mode...
if($mode == 'Add'){
  $x->response = 'GOOD';
  $x->error_message = '';
  //Insert Message...
  $miq = "INSERT INTO `chat_messages`
          (
          `date`,
          `time`,
          `channel_id`,
          `user_id`,
          `user_name`,
          `message`,
          `inactive`
          )
          VALUES
          (
          CURRENT_DATE,
          CURRENT_TIME,
          '" . $channel_id . "',
          '" . $_SESSION['user_id'] . "',
          '" . $_SESSION['user_name'] . "',
          '" . $message . "',
          'No'
          )";
  mysqli_query($conn, $miq) or die($conn->error);
  $mess_id = $conn->insert_id;
  //Insert Self View...
  $viq = "INSERT INTO `chat_message_views`
          (
          `message_id`,
          `user_id`
          )
          VALUES
          (
          '" . $mess_id . "',
          '" . $_SESSION['user_id'] . "'
          )";
  mysqli_query($conn, $viq) or die($conn->error);
}//End Add Mode...



//Notify Mode...
if($mode == 'Notify'){
  $x->response = 'GOOD';
  $x->error_message = '';
  $mq = "SELECT * FROM `chat_messages` as `m`
         WHERE `m`.`inactive` != 'Yes' 
         AND NOT EXISTS (SELECT 1 FROM `chat_message_views` as `v`
                         WHERE `v`.`message_id` = `m`.`ID`
                         AND `v`.`user_id` = '" . $_SESSION['user_id'] . "')
         ORDER BY `m`.`ID` DESC 
         LIMIT 50";
  $mg = mysqli_query($conn, $mq) or die($conn->error);
  $nCount = mysqli_num_rows($mg);
  $x->notifications = $nCount;
}//End Fetch Mode...


//Setup Response Output...
$response = json_encode($x,JSON_PRETTY_PRINT);
echo $response;