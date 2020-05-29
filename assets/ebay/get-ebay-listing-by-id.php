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
use \DTS\eBaySDK\Shopping\Services;
use \DTS\eBaySDK\Shopping\Types;
use \DTS\eBaySDK\Shopping\Enums;



/**
 * Create the service object.
 */
$service = new Services\ShoppingService([
    'credentials' => $config[$env_mode]['credentials']
]);

/**
 * Create the request object.
 */
$request = new Types\GetSingleItemRequestType();

/**
 * Specify the item ID of the listing.
 */
$request->ItemID = $itemID;

/**
 * Specify that additional fields need to be returned in the response.
 */
$request->IncludeSelector = 'ItemSpecifics,Variations,Compatibility,Details,Description';

/**
 * Send the request.
 */
$response = $service->getSingleItem($request);

/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        
      if($error->SeverityCode === Enums\SeverityCodeType::C_ERROR){
        $x->response = 'ERROR';
        $x->long_message = $error->LongMessage;
        $x->short_message = $error->ShortMessage;
      }
      
    }
}

if ($response->Ack !== 'Failure') {
  
    $item = $response->Item;
    $x->response = 'GOOD';
    $x->item_status = $item->ListingStatus;
    $x->item_data = json_decode($item);

}

$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;