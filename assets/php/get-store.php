<?php
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];
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
$service = new Services\TradingService([
    'credentials' => $config[$env_mode]['credentials'],
    'siteId'      => Constants\SiteIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\GetStoreRequestType();

/**
 * An user token is required when using the Trading service.
 *
 * NOTE: eBay will use the token to determine which store to return.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config[$env_mode]['oauthUserToken'];

/**
 * Send the request.
 */
$response = $service->getStore($request);

/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        printf(
            "%s: %s\n%s\n\n",
            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            $error->ShortMessage,
            $error->LongMessage
        );
    }
}

if ($response->Ack !== 'Failure') {
    $store = $response->Store;

    /*printf(
        "Name: %s\nDescription: %s\nURL: %s\n\n",
        $store->Name,
        $store->Description,
        $store->URL
    );*/
    //echo '<br><br>';
    $r_data = json_decode($store->CustomCategories, JSON_PRETTY_PRINT);
    $sData = json_encode($r_data, JSON_PRETTY_PRINT);
    echo $sData;
    /*foreach ($store->CustomCategories->CustomCategory as $category) {
        printCategory($category, 0);
    }*/
}

/**
 * Helper function to print some information about the passed category.
 */
function printCategory($category, $level)
{
    printf(
        "%s%s : (%s)\n",
        str_pad('', $level * 4),
        $category->Name,
        $category->CategoryID
    );

    foreach ($category->ChildCategory as $category) {
        printCategory($category, $level + 1);
    }
}

?>