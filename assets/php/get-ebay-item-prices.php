<?php
error_reporting(0);
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];

//Load Variables...
$upc_code = $_GET['upc_code'];

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
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;

/**
 * Create the service object.
 */
$service = new Services\FindingService([
    'credentials' => $config['production']['credentials'],
    'globalId'    => Constants\GlobalIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\FindItemsByProductRequest();

/**
 * Assign the product ID that we want to search for.
 * This example will use a UPC as a product ID.
 * NOTE: eBay only allow a UPC value for products in the Music (e.g. CDs), DVD and Movie, and Video Game categories.
 * Using a UPC value for any other product will result in no items been returned.
 */
$productId = new Types\ProductId();
$productId->value = $upc_code;
$productId->type = 'UPC';
$request->productId = $productId;

/**
 * Send the request.
 */
$response = $service->findItemsByProduct($request);

if (isset($response->errorMessage)) {
  $x->response = 'ERROR';
  
    $errors = [];
    foreach ($response->errorMessage->error as $error) {
      array_push($errors, array("error_type" => $error->severity=== Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning', "error_message" => $error->message));
        /*printf(
            "%s: %s\n\n",
            $error->severity=== Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
            $error->message
        );*/
    }
  $x->error_data = $errors;
}

/**
 * Output the result of the search.
 */
if ($response->ack !== 'Failure') {
  $x->response = 'GOOD';
  $values = [];
  foreach ($response->searchResult->item as $item) {
    array_push($values, $item->sellingStatus->currentPrice->value);
    //echo $item->sellingStatus->currentPrice->value . '<br>';
  }
  $x->prices = $values;
  
    /*foreach ($response->searchResult->item as $item) {
        printf(
            "(%s) %s: %s %.2f\n",
            $item->itemId,
            $item->title,
            $item->sellingStatus->currentPrice->currencyId,
            $item->sellingStatus->currentPrice->value
        );
    }*/
}
$d = json_encode($x, JSON_PRETTY_PRINT);
  echo $d;
?>