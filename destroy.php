<?php
session_start();
session_destroy();
print_r($_SESSION);
echo '<h2>Session Destroyed...</h2>';

echo '<script>
      window.location = "http://' . $_SERVER['HTTP_HOST'] . '";
      </script>';
?>