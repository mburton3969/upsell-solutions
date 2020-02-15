<?php
//Notify the browser about the type of the file using header function
header('Content-type: text/javascript');
session_start();
error_reporting(0);
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
 * Specify the numerical site id that we want the listing to appear on.
 *
 * This determines the validation rules that eBay will apply to the request.
 * For example, it will determine what categories can be specified, the values
 * allowed as shipping services, the visibility of the item in some searches and other
 * information.
 *
 * Note that due to the risk of listing fees been raised this example will list the item
 * to the sandbox site.
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
$request = new Types\GetCategorySpecificsRequestType();

//Load Category ID...
$catID = $_GET['category_id'];

$request->CategoryID = [$catID];

$response = $service->GetCategorySpecifics($request);

/**
 * Output the result of calling the service operation.
 */
$response2 = json_decode($response);
//echo json_encode($response2, JSON_PRETTY_PRINT) . '<br><br><br>';
$i = 0;
$x->ItemSpecific = [];
foreach($response->Recommendations[0]->NameRecommendation as $rec){
  $z;
  if($rec->ValidationRules->MinValues == 1 && $rec->Name != 'Brand'){
    //$rec2 = json_decode($rec);
    //echo json_encode($rec2, JSON_PRETTY_PRINT);
    //$x->ItemSpecific[$i]->Name = $rec->Name;
    //$x->ItemSpecific[$i]->Values = [];
    $values = [];
    foreach($rec->ValueRecommendation as $val){
      array_push($values, $val->Value);
    }
    //$fz = json_encode($z);
    //$x->ItemSpecific[$i] = $z;
    array_push($x->ItemSpecific, array('Name' => $rec->Name, 'Values' => $values));
  }
  $i++;
}
$x->response = 'GOOD';
$response = json_encode($x, JSON_PRETTY_PRINT);

echo $response;

?>