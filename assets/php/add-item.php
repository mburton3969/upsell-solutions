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
$product_description = $_POST['product_description'];

//Product Details...
$product_brand = $_POST['product_brand'];
$product_color = $_POST['product_color'];
$product_sizetype = $_POST['product_sizetype'];
$product_style = $_POST['product_style'];
$product_sleevelength = $_POST['product_sleevelength'];

$product_label = $_POST['product_label'];

//$product_category = $_POST['product_category'];
$product_category = $_POST['cur_cat'];

$product_condition = $_POST['product_condition'];

//Images...
$product_image1 = $_POST['img_url1'];
$product_image2 = $_POST['img_url2'];
$product_image3 = $_POST['img_url3'];

$product_price = $_POST['product_price'];
$product_quantity = $_POST['product_quantity'];

//Package Dimensions...
$product_pkg_width = $_POST['product_pkg_width'];
$product_pkg_length = $_POST['product_pkg_length'];
$product_pkg_depth = $_POST['product_pkg_depth'];

//Package Weight...
$product_pkg_lbs = $_POST['product_pkg_lbs'];
$product_pkg_oz = $_POST['product_pkg_oz'];

//Shipping Service...
$shipping_service_option = $_POST['product_ship_option'];

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
//$item->SKU = 'ABC-001';
$item->SKU = $product_label;

$item->ItemSpecifics = new Types\NameValueListArrayType();
$item->ItemSpecifics->NameValueList[] = new Types\NameValueListType([
    'Name' => 'Brand',
    'Value' => $product_brand
]);

$specific = new Types\NameValueListType();
$specific->Name = 'Size Type';
$specific->Value[] = $product_sizetype;
$item->ItemSpecifics->NameValueList[] = $specific;


$specific = new Types\NameValueListType();
$specific->Name = 'Style';
$specific->Value[] = $product_style;
$item->ItemSpecifics->NameValueList[] = $specific;


$specific = new Types\NameValueListType();
$specific->Name = "Size (Women's)";
$specific->Value[] = $product_sizetype;
$item->ItemSpecifics->NameValueList[] = $specific;

$specific = new Types\NameValueListType();
$specific->Name = "Sleeve Length";
$specific->Value[] = $product_sleevelength;
$item->ItemSpecifics->NameValueList[] = $specific;

$specific = new Types\NameValueListType();
$specific->Name = "Color";
$specific->Value[] = $product_color;
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
if($product_image1 != '' && $product_image1 != 'undefined'){
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
}
/**
 * List item in the Books > Audiobooks (29792) category.
 */
$item->PrimaryCategory = new Types\CategoryType();
$item->PrimaryCategory->CategoryID = $product_category;
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
$item->PayPalEmailAddress = 'mburton3969@gmail.com';
$item->DispatchTimeMax = 3;
/**
 * Setting up the shipping details.
 * We will use a Flat shipping rate for both domestic and international.
 */
$item->ShippingDetails = new Types\ShippingDetailsType();
$item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_CALCULATED;
/**
 * Sellers can charge a fee (in addition to whatever the shipping service might charge) for packaging/handling costs.
 * For this example the seller will charge $1.99 for domestic and $2.99 for international packaging.
 */
$item->ShippingDetails->CalculatedShippingRate = new Types\CalculatedShippingRateType();
//$item->ShippingDetails->CalculatedShippingRate->PackagingHandlingCosts = new Types\AmountType(['value' => 1.99]);
//$item->ShippingDetails->CalculatedShippingRate->InternationalPackagingHandlingCosts = new Types\AmountType(['value' => 2.99]);
$item->ShippingDetails->CalculatedShippingRate->OriginatingPostalCode = '20175';

/**
 * Using Calculated shipping requires specifying the dimensions and weight of the package.
 * Note that we are listing to the US site and so dimensions are specified in inches
 * and the weight in pounds and ounces. Other sites will use different units.
 */
$packageDetails = new Types\ShipPackageDetailsType();
$packageDetails->ShippingPackage = 'PackageThickEnvelope';
$packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
$packageDetails->ShippingIrregular = false;
$packageDetails->PackageWidth = new Types\MeasureType();
$packageDetails->PackageWidth->unit = 'in';
$packageDetails->PackageWidth->value = intval($product_pkg_width);
$packageDetails->PackageLength = new Types\MeasureType();
$packageDetails->PackageLength->unit = 'in';
$packageDetails->PackageLength->value = intval($product_pkg_length);
$packageDetails->PackageDepth = new Types\MeasureType();
$packageDetails->PackageDepth->unit = 'in';
$packageDetails->PackageDepth->value = intval($product_pkg_depth);
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
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 1;
$shippingService->ShippingService = $shipping_service_option;
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
$item->ReturnPolicy->ReturnsWithinOption = 'Days_14';
$item->ReturnPolicy->ShippingCostPaidByOption = 'Buyer';
/**
 * Finish the request object.
 */
$request->Item = $item;
/**
 * Send the request.
 */
$response = $service->addFixedPriceItem($request);
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
    printf(
        "The item was listed on eBay with the Item number %s\n",
        $response->ItemID
    );
}

echo '<div style="width:100%;text-align:center;">
        <a href="http://81demo.ignition-innovations.com/" style="background:blue;padding:10px;border-radius:25px;color:white;">Continue</a>
      </div>';

?>