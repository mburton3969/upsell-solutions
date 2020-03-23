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
$request = new Types\AddFixedPriceItemRequestType();
/**
 * An user token is required when using the Trading service.
 */
//$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
//$request->RequesterCredentials->eBayAuthToken = $config[$env_mode]['authToken'];

/**
 * Begin creating the fixed price item.
 */
$item = new Types\ItemType();

//Load Form Variables...
$product_code = $_POST['product_code'];
$product_title = $_POST['product_title'];
//$product_description = $_POST['product_description'];
$product_description = nl2br($_POST['product_description']);

//Product Details...
$product_brand = $_POST['product_brand'];
$product_color = $_POST['product_color'];
$product_sizetype = $_POST['product_sizetype'];
$product_style = $_POST['product_style'];
$product_sleevelength = $_POST['product_sleevelength'];
$product_material = $_POST['product_material'];

$product_label = $_POST['product_label'];

//$product_category = $_POST['product_category'];
$product_category = $_POST['cur_cat'];
$product_store_category = $_POST['cur_store_cat'];

$product_condition = $_POST['product_condition'];

//Images...
$product_image1 = $_POST['img_url1'];
$product_image2 = $_POST['img_url2'];
$product_image3 = $_POST['img_url3'];
$product_image4 = $_POST['img_url4'];
$product_image5 = $_POST['img_url5'];

$product_price = $_POST['product_price'];
$product_quantity = $_POST['product_quantity'];

//Package Dimensions...
//$product_pkg_width = $_POST['product_pkg_width'];
//$product_pkg_length = $_POST['product_pkg_length'];
//$product_pkg_depth = $_POST['product_pkg_depth'];
$product_pkg_width = '11';
$product_pkg_length = '15';
$product_pkg_depth = '5';

//Package Weight...
$product_pkg_lbs = $_POST['product_pkg_lbs'];
$product_pkg_oz = $_POST['product_pkg_oz'];
$oz_to_lbs = ($product_pkg_oz / 16);
$pkg_weight = ($product_pkg_lbs + $oz_to_lbs);
//check if under or over 1 pound...
if($pkg_weight <= 1){
    $shipping_service_option = 'USPSFirstClass';
}else{
    $shipping_service_option = 'USPSPriority';
}

//Shipping Service...
//$shipping_service_option = $_POST['product_ship_option'];

//Returns Options...
//$returns_option = $_POST['returns_accepted_option'];
//$returns_within = $_POST['returns_accepted_within_option'];
//$refund_method = $_POST['refund_option'];
//$return_shipping_option = $_POST['return_shipping_option'];

/**
 * We want a multiple quantity fixed price listing.
 */
$item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
$item->Quantity = intval($product_quantity);
/**
 * Let the listing be automatically renewed every 30 days until cancelled.
 */
$item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;
/**
 * The cost of the item is $19.99.
 * Note that we don't have to specify a currency as eBay will use the site id
 * that we provided earlier to determine that it will be United States Dollars (USD).
 */
$iPrice = floatval($product_price);
$item->StartPrice = new Types\AmountType(['value' => $iPrice]);
/**
 * Allow buyers to submit a best offer.
 */
$item->BestOfferDetails = new Types\BestOfferDetailsType();
$item->BestOfferDetails->BestOfferEnabled = false;
/**
 * Automatically accept best offers of $17.99 and decline offers lower than $15.99.
 */
//$item->ListingDetails = new Types\ListingDetailsType();
//$item->ListingDetails->BestOfferAutoAcceptPrice = new Types\AmountType(['value' => 17.99]);
//$item->ListingDetails->MinimumBestOfferPrice = new Types\AmountType(['value' => 15.99]);
/**
 * Provide a title and description and other information such as the item's location.
 * Note that any HTML in the title or description must be converted to HTML entities.
 */
$item->Title = $product_title;
$item->Description = $product_description;
$item->SKU = $product_label;//Was $product_code...

//Add The Product UPC Code...
$item->ProductListingDetails = new Types\ProductListingDetailsType();
$item->ProductListingDetails->UPC = $product_code;

$item->ItemSpecifics = new Types\NameValueListArrayType();
$item->ItemSpecifics->NameValueList[] = new Types\NameValueListType([
    'Name' => 'Brand',
    'Value' => [$product_brand]
]);
//Material Item Specific...
//Item Custom Label...
$specific = new Types\NameValueListType();
$specific->Name = 'Material';
$specific->Value[] = $product_material;
$item->ItemSpecifics->NameValueList[] = $specific;

$is_array = explode(',',$_POST['item_specifics_array']);
foreach($is_array as $is){
    if($_POST['product_'.$is] != ''){
        $specific = new Types\NameValueListType();
        $specific->Name = str_replace('_',' ',$is);
        $specific->Value[] = $_POST['product_'.$is];
        $item->ItemSpecifics->NameValueList[] = $specific;
    }
}

//Item Custom Label...
/*$specific = new Types\NameValueListType();
$specific->Name = 'Custom Label';
$specific->Value[] = $product_label;
$item->ItemSpecifics->NameValueList[] = $specific;*/

//Item UPC Code...
$specific = new Types\NameValueListType();
$specific->Name = 'UPC';
$specific->Value[] = $product_code;
$item->ItemSpecifics->NameValueList[] = $specific;


$item->Country = 'US';
$item->Location = 'Leesburg';
$item->PostalCode = '20175';
/**
 * This is a required field.
 */
$item->Currency = 'USD';
/**
 * Display a picture with the item.
 */
$item->PictureDetails = new Types\PictureDetailsType();
$item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
//$item->PictureDetails->PictureURL = ['http://lorempixel.com/1500/1024/abstract'];
/*if($product_image1 != '' && $product_image1 != 'undefined'){
  $item->PictureDetails->PictureURL = [
      $product_image1
  ];
}elseif($product_image2 != '' && $product_image2 != 'undefined'){
  $item->PictureDetails->PictureURL = [
      $product_image1,
      $product_image2
  ];
}elseif($product_image3 != '' && $product_image3 != 'undefined'){
  $item->PictureDetails->PictureURL = [
      $product_image1,
      $product_image2,
      $product_image3
  ];
}else{
  $item->PictureDetails->PictureURL = [
      
  ];
}*/
$img_array = [];
if($product_image1 != '' && $product_image1 != 'undefined'){
  array_push($img_array, $product_image1);
}
if($product_image2 != '' && $product_image2 != 'undefined'){
  array_push($img_array, $product_image2);
}
if($product_image3 != '' && $product_image3 != 'undefined'){
  array_push($img_array, $product_image3);
}
if($product_image4 != '' && $product_image4 != 'undefined'){
  array_push($img_array, $product_image4);
}
if($product_image5 != '' && $product_image5 != 'undefined'){
  array_push($img_array, $product_image5);
}
  
$item->PictureDetails->PictureURL = $img_array;
/**
 * List item in the selected category.
 */
$item->PrimaryCategory = new Types\CategoryType();
$item->PrimaryCategory->CategoryID = $product_category;
//Store Category...
$item->Storefront = new Types\StorefrontType();
$item->Storefront->StoreCategoryID = intval($product_store_category);
/**
 * Tell buyers what condition the item is in.
 * For the category that we are listing in the value of 1000 is for Brand New.
 */
$item->ConditionID = intval($product_condition);
/**
 * Buyers can use one of two payment methods when purchasing the item.
 * Visa / Master Card
 * PayPal
 * The item will be dispatched within 1 business days once payment has cleared.
 * Note that you have to provide the PayPal account that the seller will use.
 * This is because a seller may have more than one PayPal account.
 */
$item->PaymentMethods = [
    'VisaMC',
    'PayPal'
];
$item->PayPalEmailAddress = '81outfitters@gmail.com';
$item->DispatchTimeMax = 3;
/**
 * Setting up the shipping details.
 * We will use a Flat shipping rate for both domestic and international.
 */
$item->ShippingDetails = new Types\ShippingDetailsType();
$item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;//C_FLAT or C_CALCULATED
/**
 * Sellers can charge a fee (in addition to whatever the shipping service might charge) for packaging/handling costs.
 * For this example the seller will charge $1.99 for domestic and $2.99 for international packaging.
 */
//$item->ShippingDetails->CalculatedShippingRate = new Types\CalculatedShippingRateType();
//$item->ShippingDetails->CalculatedShippingRate->PackagingHandlingCosts = new Types\AmountType(['value' => 1.99]);
//$item->ShippingDetails->CalculatedShippingRate->InternationalPackagingHandlingCosts = new Types\AmountType(['value' => 2.99]);
//$item->ShippingDetails->CalculatedShippingRate->OriginatingPostalCode = '20175';

/**
 * Using Calculated shipping requires specifying the dimensions and weight of the package.
 * Note that we are listing to the US site and so dimensions are specified in inches
 * and the weight in pounds and ounces. Other sites will use different units.
 */

$packageDetails = new Types\ShipPackageDetailsType();
$packageDetails->ShippingPackage = 'USPSLargePack';
$packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
$packageDetails->ShippingIrregular = false;
//$packageDetails->PackageWidth = new Types\MeasureType();
//$packageDetails->PackageWidth->unit = 'in';
//$packageDetails->PackageWidth->value = intval($product_pkg_width);
//$packageDetails->PackageLength = new Types\MeasureType();
//$packageDetails->PackageLength->unit = 'in';
//$packageDetails->PackageLength->value = intval($product_pkg_length);
//$packageDetails->PackageDepth = new Types\MeasureType();
//$packageDetails->PackageDepth->unit = 'in';
//$packageDetails->PackageDepth->value = intval($product_pkg_depth);
$packageDetails->WeightMajor = new Types\MeasureType();
$packageDetails->WeightMajor->unit = 'lbs';
$packageDetails->WeightMajor->value = intval($product_pkg_lbs);

/**
 * The SDK allows properties to be specified when constructing new objects.
 * By taking advantage of this feature we add details as follows.
 */
$packageDetails->WeightMinor = new Types\MeasureType([
    'unit' => 'oz',
    'value' => intval($product_pkg_oz)
]);
$item->ShippingPackageDetails = $packageDetails;
/**
 * Create our first domestic shipping option.
 * Offer the USPS Parcel Select (2-9 business days)
 *
 * Note that not all shipping services can be used with Calculated shipping.
 * To determine which can be used is beyond the scope of this example, but in summary:
 *
 * A call is made to the GeteBayDetails operation for the site that you are listing to.
 * The value ShippingServiceDetails is specified in the DetailName field in the request.
 * Iterate through the ShippingServiceDetails collection in the response.
 * Each item is a shipping service that can support more than one type of shipping.
 * Ignore any service where the ValidForSellingFlow property is false or not present. (This indicates that you cannot list with this service!)
 * For each service iterate over the ServiceType collection. If any have the value of Calculated then
 * the service can be used with Calculated shipping.
 */
/*
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 1;
$shippingService->ShippingService = $shipping_service_option;
$item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
*/
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 1;
$shippingService->ShippingService = $shipping_service_option;
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 0.00]);//Shipping Cost for 1st Item
//$shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 2.00]);//Shipping cost for additional items
$item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

/**
 * The return policy.
 * Returns are accepted.
 * A refund will be given as money back.
 * The buyer will have 14 days in which to contact the seller after receiving the item.
 * The buyer will pay the return shipping cost.
 */

$item->ReturnPolicy = new Types\ReturnPolicyType();
$item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';
$item->ReturnPolicy->RefundOption = 'MoneyBack';
$item->ReturnPolicy->ReturnsWithinOption = 'Days_30';
$item->ReturnPolicy->ShippingCostPaidByOption = 'Seller';
//$item->ReturnPolicy->ReturnsAcceptedOption = $returns_option;
//$item->ReturnPolicy->RefundOption = $refund_method;
//$item->ReturnPolicy->ReturnsWithinOption = $returns_within;
//$item->ReturnPolicy->ShippingCostPaidByOption = $return_shipping_option;
/**
 * Finish the request object.
 */
$request->Item = $item;
/**
 * Send the request.
 */
$response = $service->addFixedPriceItem($request);

echo '<html>
      <head>
        <title>Add Item</title>
      </head>
      <body>';

echo '<div id="status">
        <h1 id="lStatus"></h1>
      </div>';

echo '<div id="errors" style="padding:10px;background:rgba(255,49,3,0.5);">
        <h3 style=""><u>Required Additions [These must be corrected for the item to be listed]:</u></h3>
      </div>';

echo '<div id="warnings" style="padding:10px;background:rgba(255,251,0,0.5);">
        <h3 style=""><u>Suggested Additions:</u></h3>
      </div>';
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
      $error_type = $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning';
      if($error_type == 'Error'){
        echo '<script>
                var errors = document.getElementById("errors");
                var h4 = document.createElement("h4");
                h4.innerHTML = "' . $error->LongMessage . '";
                errors.appendChild(h4);
              </script>';
        //echo '<h1>' . $error_type . '</h1>';
        //echo '<h4>' . $error->ShortMessage . '</h4>';
        //echo '<h4>' . $error->LongMessage . '</h4>';
      }elseif($error_type == 'Warning'){
        echo '<script>
                var warnings = document.getElementById("warnings");
                var h4 = document.createElement("h4");
                h4.innerHTML = "' . $error->LongMessage . '";
                warnings.appendChild(h4);
              </script>';
      }
    }
}
if ($response->Ack !== 'Failure') {
    /*printf(
        "The item was listed on eBay with the Item number %s\n",
        $response->ItemID
    );*/
    echo '<script>
            document.getElementById("lStatus").innerHTML = "<span style=\"color:green;\">Listing Status: LISTED [Item#: ' . $response->ItemID . ']</span>";
          </script>';
}else{
    echo '<script>
            document.getElementById("lStatus").innerHTML = "<span style=\"color:red;\">Listing Status: NOT LISTED</span>";
          </script>';
}

echo '<div style="width:100%;text-align:center;">
        <br><br>
        <a href="http://' . $_SERVER['HTTP_HOST'] . '/" style="background:blue;padding:10px;border-radius:25px;color:white;">Continue</a>
      </div>';

echo '</body>
      </html>';
?>