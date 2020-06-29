<?php
if($_SESSION['logged_in'] != 'Yes'){
  echo '<script>
          window.location = "http://' . $_SERVER['HTTP_HOST'] . '/login.php?logout=yes";
        </script>';
}