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

//$request->RequesterCredentials->Credentials = new Types\UserIdPasswordType();
//$request->RequesterCredentials->Credentials->AppId = $config[$env_mode]['credentials']['appId'];
//$request->RequesterCredentials->Credentials->DevId = $config[$env_mode]['credentials']['devId'];
//$request->RequesterCredentials->Credentials->AuthCert = $config[$env_mode]['credentials']['certId'];
//$request->RequesterCredentials->Credentials->Username = $un;
//$request->RequesterCredentials->Credentials->Password = $ps;
/**
 * Begin creating the fixed price item.
 */
$item = new Types\ItemType();

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
    'Value' => ['Unknown']
]);

$specific = new Types\NameValueListType();
$specific->Name = 'Size Type';
$specific->Value[] = 'XL';
$item->ItemSpecifics->NameValueList[] = $specific;

$specific = new Types\NameValueListType();
$specific->Name = 'Style';
$specific->Value[] = 'Boxers';
$item->ItemSpecifics->NameValueList[] = $specific;

$specific = new Types\NameValueListType();
$specific->Name = "Bottoms Size (Men's)";
$specific->Value[] = 'XL';
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
$item->ConditionID = $product_condition;
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
$item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;
/**
 * Create our first domestic shipping option.
 * Offer the Economy Shipping (1-10 business days) service at $2.00 for the first item.
 * Additional items will be shipped at $1.00.
 */
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 1;
$shippingService->ShippingService = 'Other';
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 2.00]);
$shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 1.00]);
$item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
/**
 * Create our second domestic shipping option.
 * Offer the USPS Parcel Select (2-9 business days) at $3.00 for the first item.
 * Additional items will be shipped at $2.00.
 */
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 2;
$shippingService->ShippingService = 'USPSParcel';
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 3.00]);
$shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 2.00]);
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
        "The item was listed on eBay Sandbox with the Item number %s\n",
        $response->ItemID
    );
}

?>