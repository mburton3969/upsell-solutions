<?php
session_start();
$env_mode = $_SESSION['ebay_mode'];
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
use \DTS\eBaySDK\Catalog\Services;
use \DTS\eBaySDK\Catalog\Types;
use \DTS\eBaySDK\Catalog\Enums;
/**
 * Create the service object.
 */
$service = new Services\CatalogService([
    'authorization' => $config[$env_mode]['oauthUserToken']
    //,'httpOptions' => ['debug' => true]
]);
/**
 * Create the request object.
 */
$request = new Types\SearchRestRequest();
$request->q = 'iphone';
$request->limit = '3';
/**
 * Send the request.
 */
$response = $service->search($request);
/**
 * Output the result of calling the service operation.
 */
printf("\nStatus Code: %s\n\n", $response->getStatusCode());
if (isset($response->errors)) {
    foreach ($response->errors as $error) {
        printf(
            "%s: %s\n%s\n\n",
            $error->errorId,
            $error->message,
            $error->longMessage
        );
    }
}
if ($response->getStatusCode() === 200) {
    foreach ($response->productSummaries as $productSummary) {
        printf(
            "%s\n%s\n",
            $productSummary->title,
            $productSummary->brand
        );
    }
}

?>