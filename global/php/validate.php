<?php
session_start();
include 'connection.php';

//Load Variables...
$user = mysqli_real_escape_string($conn, $_REQUEST['username']);
$pass = mysqli_real_escape_string($conn, $_REQUEST['password']);

//Check User Validity...
$q = "SELECT * FROM `users` WHERE `inactive` != 'Yes' AND `username` = '" . $user . "' AND `password` = '" . $pass . "'";
$g = mysqli_query($conn, $q) or die($conn->error);

if(mysqli_num_rows($g) <= 0){//if User does NOT exist...
  
  $error = 'Invalid Username/Password';
  echo '<script>
          window.location = "../../login.php?e=' . $error . '";
        </script>';
  
}else{//if User does exist...
  
  $r = mysqli_fetch_array($g);
  
  //Setup Session Variables...
  $_SESSION['logged_in'] = 'Yes';
  $_SESSION['user_id'] = $r['ID'];
  $_SESSION['fname'] = $r['fname'];
  $_SESSION['lname'] = $r['lname'];
  $_SESSION['user_name'] = $r['fname'] . ' ' . $r['lname'];
  $_SESSION['app_version'] = '3.4.0';
  
  echo '<script>
          window.location = "../../dashboard.php";
        </script>';
  
}
