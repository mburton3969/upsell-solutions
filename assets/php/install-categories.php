<?php
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];
include 'connection.php';
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
    'authorization' => $config[$env_mode]['oauthUserToken'],
    'requestLanguage'  => 'en-US',
    'responseLanguage' => 'en-US',
    'siteId'      => Constants\SiteIds::US
]);
/**
 * Create the request object.
 */
$request = new Types\GetCategoriesRequestType();
/**
 * An user token is required when using the Trading service.
 *///echo $config[$env_mode]['authToken'];
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config[$env_mode]['oauthUserToken'];
/**
 * By specifying 'ReturnAll' we are telling the API return the full category hierarchy.
 */
$request->DetailLevel = ['ReturnAll'];
/**
 * OutputSelector can be used to reduce the amount of data returned by the API.
 * http://developer.ebay.com/DevZone/XML/docs/Reference/ebay/GetCategories.html#Request.OutputSelector
 */
$request->OutputSelector = [
    'CategoryArray.Category.CategoryID',
    'CategoryArray.Category.CategoryParentID',
    'CategoryArray.Category.CategoryLevel',
    'CategoryArray.Category.CategoryName'
];
/**
 * Send the request.
 */
$response = $service->getCategories($request);
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
    /**
     * For the US site this will output approximately 18,000 categories.
     */
  $i = 0;
    foreach ($response->CategoryArray->Category as $category) {
      /*$x->res[$i] = new stdClass;
      $x->res[$i]->level = $category->CategoryLevel;
      $x->res[$i]->name = $category->CategoryName;
      $x->res[$i]->ID = $category->CategoryID;
      $x->res[$i]->parentID = $category->CategoryParentID[0];
      */
      $iq = "INSERT INTO `ebay_categories`
            (
            `category_level`,
            `category_name`,
            `category_id`,
            `parent_id`,
            `inactive`
            )
            VALUES
            (
            '" . $category->CategoryLevel . "',
            '" . mysqli_real_escape_string($conn, $category->CategoryName) . "',
            '" . $category->CategoryID . "',
            '" . $category->CategoryParentID[0] . "',
            'No'
            )";
      //mysqli_query($conn, $iq) or die($conn->error);
        /*printf(
            "Level %s : %s (%s) : Parent ID %s\n",
            $category->CategoryLevel,
            $category->CategoryName,
            $category->CategoryID,
            $category->CategoryParentID[0]
        );*/
      $i++;
    }
  //$res = json_encode($x);
  //echo $res;
  echo 'Import Complete...';
}

?>