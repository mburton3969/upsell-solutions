<?php
session_start();
//session_destroy();
unset($_SESSION['auth_code']);
unset($_SESSION['app_token']);
unset($_SESSION['user_token']);
unset($_SESSION['refresh_token']);
unset($_SESSION['form_data']);
print_r($_SESSION);

echo '<h2>Ebay Session Variables Removed...</h2>';

echo '<script>
      //window.location = "http://' . $_SERVER['HTTP_HOST'] . '";
      </script>';
?>