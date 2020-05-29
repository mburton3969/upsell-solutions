<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];

//Load Variables...
$itemID = $_REQUEST['iid'];

/**
 * Include the Database Connection File.
 */
include '../php/connection.php';
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
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

/**
 * Create the service object.
 */
$siteId = Constants\SiteIds::US;
/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config[$env_mode]['credentials'],
    'authorization' => $config[$env_mode]['oauthUserToken'],
    'requestLanguage'  => 'en-US',
    'responseLanguage' => 'en-US',
    'sandbox'     => $env_mode_val,
    'siteId'      => $siteId
]);

/**
 * Create the request object.
 */
$request = new Types\GetApiAccessRulesRequestType();



/**
 * Send the request.
 */
$response = $service->getApiAccessRules($request);

/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        /*printf(
            "%s: %s\n%s\n\n",
            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            $error->ShortMessage,
            $error->LongMessage
        );*/
      if($error->SeverityCode === Enums\SeverityCodeType::C_ERROR){
        $x->response = 'ERROR';
        $x->long_message = $error->LongMessage;
        $x->short_message = $error->ShortMessage;
      }
    }
}

if ($response->Ack !== 'Failure') {
    
   $x->data = json_decode($response);
}

$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;