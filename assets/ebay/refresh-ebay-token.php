<?php
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];

if($_SERVER['QUERY_STRING'] != ''){
  $qs = '?' . $_SERVER['QUERY_STRING'];
}else{
  $qs = '';
}
/**
 * Copyright 2017 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * Include the SDK by using the autoloader from Composer.
 */
require __DIR__.'/../vendor/autoload.php';
/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
$config = require __DIR__.'/../php/ebay-config.php';
/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\OAuth\Services;
use \DTS\eBaySDK\OAuth\Types;
/**
 * Create the service object.
 */
$service = new Services\OAuthService([
    'credentials' => $config[$env_mode]['credentials'],
    'ruName'      => $config[$env_mode]['ruName'],
    'sandbox'     => $env_mode_val
]);
/**
 * Create the request object.
 */
$request = new Types\RefreshUserTokenRestRequest();
$request->refresh_token = $_SESSION['refresh_token'];
$request->scope = [
    'https://api.ebay.com/oauth/api_scope/sell.account',
    'https://api.ebay.com/oauth/api_scope/sell.inventory',
    'https://api.ebay.com/oauth/api_scope/sell.fulfillment',
    'https://api.ebay.com/oauth/api_scope'
];
/**
 * Send the request.
 */
$response = $service->refreshUserToken($request);
/**
 * Output the result of calling the service operation.
 */
printf("\nStatus Code: %s\n\n", $response->getStatusCode());
if ($response->getStatusCode() !== 200) {
    printf(
        "%s: %s\n\n",
        $response->error,
        $response->error_description
    );
  echo '<br><br><br>
        <a href="../../destroy.php">Correct Error</a>';
} else {
  $_SESSION['user_token'] = $response->access_token;
  //$_SESSION['refresh_token'] = $response->refresh_token;
    /*printf(
        "%s\n%s\n%s\n%s\n\n",
        $response->access_token,
        $response->token_type,
        $response->expires_in,
        $response->refresh_token
    );*/
  echo '<script>
        window.location = "http://' . $_SERVER['HTTP_HOST'] . '/index.php' . $qs . '";
        </script>';
}