<?php
session_start();
session_destroy();
print_r($_SESSION);
echo '<h2>Session Destroyed...</h2>';

echo '<script>
      window.location = "http://81demo.ignition-innovations.com";
      </script>';
?>