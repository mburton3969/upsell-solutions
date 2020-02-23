<?php
session_start();

echo '<h4>Auth Code:</h4>';
echo '<p>' . $_SESSION['auth_code'] . '</p>';

echo '<h4>Refresh Token:</h4>';
echo '<p>' . $_SESSION['refresh_token'] . '</p>';

echo '<h4>App Token:</h4>';
echo '<p>' . $_SESSION['app_token'] . '</p>';

echo '<h4>User Token:</h4>';
echo '<p>' . $_SESSION['user_token'] . '</p>';

echo '<h4>Session Data:</h4>';
echo '<p>';
print_r($_SESSION);
echo '</p>';
?>