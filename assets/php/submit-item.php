<?php
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];
/**
 * Include the SDK by using the autoloader from Composer.
 */
require '../vendor/autoload.php';
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
use \DTS\eBaySDK\Inventory\Services;
use \DTS\eBaySDK\Inventory\Types;
use \DTS\eBaySDK\Inventory\Enums;
/**
 * Include the Database Connection File.
 */
//include 'connection.php';
/**
 * Create the service object.
 */
$service = new Services\InventoryService([
    'authorization'    => $config[$env_mode]['oauthUserToken'],
    'requestLanguage'  => 'en-US',
    'responseLanguage' => 'en-US',
    'sandbox'          => $env_mode_val
]);
/**
 * Create the request object.
 */
$request = new Types\CreateOrReplaceInventoryItemRestRequest();

//Load Form Variables...
$product_title = $_POST['product_title'];
$product_description = $_POST['product_description'];
$product_label = $_POST['product_label'];
$product_category = $_POST['product_category'];
$product_code = $_POST['product_code'];
$product_condition = $_POST['product_condition'];
$product_image1 = $_POST['img_url1'];
$product_image2 = $_POST['img_url2'];
$product_image3 = $_POST['img_url3'];
$product_price = $_POST['product_price'];
$product_quantity = $_POST['product_quantity'];

/**
 * Note how URI parameters are just properties on the request object.
 */
$request->sku = $product_code;
$request->availability = new Types\Availability();
$request->availability->shipToLocationAvailability = new Types\ShipToLocationAvailability();
$request->availability->shipToLocationAvailability->quantity = intval($product_quantity);

$request->condition = Enums\ConditionEnum::C_NEW_OTHER;

$request->product = new Types\Product();
$request->product->title = $product_title;
$request->product->description = $product_description;

//$request->packageWeightandSize = new Types\packageWeightandSize();
//$request->packageWeightandSize
/**
 * Aspects are specified as an associative array.
 */
/*$request->product->aspects = [
    'Brand'                => ['GoPro'],
    'Type'                 => ['Helmet/Action'],
    'Storage Type'         => ['Removable'],
    'Recording Definition' => ['High Definition'],
    'Media Format'         => ['Flash Drive (SSD)'],
    'Optical Zoom'         => ['10x', '8x', '4x']
];*/
if($product_image1 != '' && $product_image1 != 'undefined'){
  $request->product->imageUrls = [
      $product_image1
  ];
}elseif($product_image2 != '' && $product_image2 != 'undefined'){
  $request->product->imageUrls = [
      $product_image1,
      $product_image2
  ];
}elseif($product_image3 != '' && $product_image3 != 'undefined'){
  $request->product->imageUrls = [
      $product_image1,
      $product_image2,
      $product_image3
  ];
}else{
  $request->product->imageUrls = [
      
  ];
}

/**
 * Send the request.
 */
$response = $service->createOrReplaceInventoryItem($request);
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
if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 400) {
    echo "Success\n";
}

if($response->getStatusCode() == 204){
  echo '<script>
          window.location = "http://81demo.ignition-innovations.com/?res_code=' . $response->getStatusCode() . '";
        </script>';
}