<?php
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];
$_SESSION['form_data'] = '';
$_SESSION['retry'] = 'No';
/**
 * Include the Database Connection File.
 */
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

//error_reporting(0);

//Load Form Variables...
$product_code = $_REQUEST['product_code'];
$product_title = $_REQUEST['product_title'];

$pd = $_REQUEST['product_description'];
$pd_extra = $_REQUEST['product_description_extra'];
$pd_footer = $_REQUEST['product_description_footer'];
$fpd = '<p>' . $pd . '</p><p>' . $pd_extra . '</p><p>' . $pd_footer . '</p>';
$wfpd = '<p>' . $pd . '</p><p>' . $pd_extra . '</p>';
$product_description = nl2br($fpd);
$website_product_description = nl2br($wfpd);
//$product_description = nl2br($_REQUEST['product_description']);

//Product Details...
$product_brand = $_REQUEST['product_brand'];
$product_color = $_REQUEST['product_color'];
$product_size_type = $_REQUEST['product_Size_Type'];
$product_style = $_REQUEST['product_Style'];
$product_sleevelength = $_REQUEST['product_sleevelength'];
$product_material = $_REQUEST['product_material'];
$product_size = $_REQUEST['product_Size'];
$product_Type = $_REQUEST['product_Type'];

$product_label = $_REQUEST['product_label'];
$website_product_title = $product_brand . ' ' . $product_title;

//$product_category = $_REQUEST['product_category'];
$product_section = $_REQUEST['product_section'];
$product_category = $_REQUEST['cur_cat'];
$product_store_category = $_REQUEST['cur_store_cat'];
$prod_81_cat = $_REQUEST['cur_81_cat'];
$product_81_store_category = $_REQUEST['product_81_store_category_' . $prod_81_cat];
$prod_81_cat_1 = $_REQUEST['product_81_store_category_1'];
$prod_81_cat_2 = $_REQUEST['product_81_store_category_2'];
$prod_81_cat_3 = $_REQUEST['product_81_store_category_3'];
$prod_81_cat_4 = $_REQUEST['product_81_store_category_4'];


$product_condition = $_REQUEST['product_condition'];

//Images...
$product_image1 = $_REQUEST['img_url1'];
$product_image2 = $_REQUEST['img_url2'];
$product_image3 = $_REQUEST['img_url3'];
$product_image4 = $_REQUEST['img_url4'];
$product_image5 = $_REQUEST['img_url5'];

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
  

$product_price = $_REQUEST['product_price'];
$website_product_price = $_REQUEST['website_product_price'];
$product_quantity = $_REQUEST['product_quantity'];

//Package Dimensions...
//$product_pkg_width = $_REQUEST['product_pkg_width'];
//$product_pkg_length = $_REQUEST['product_pkg_length'];
//$product_pkg_depth = $_REQUEST['product_pkg_depth'];
$product_pkg_width = '11';
$product_pkg_length = '14';
$product_pkg_depth = '2';

//Package Weight...
$product_pkg_lbs = $_REQUEST['product_pkg_lbs'];
$product_pkg_oz = $_REQUEST['product_pkg_oz'];
$oz_to_lbs = ($product_pkg_oz / 16);
$pkg_weight = ($product_pkg_lbs + $oz_to_lbs);
//check if under or over 1 pound...
if($pkg_weight <= 1){
    $shipping_service_option = 'USPSFirstClass';
}else{
    $shipping_service_option = 'USPSPriority';
}

//Shipping Service...
//$shipping_service_option = $_REQUEST['product_ship_option'];

//Returns Options...
//$returns_option = $_REQUEST['returns_accepted_option'];
//$returns_within = $_REQUEST['returns_accepted_within_option'];
//$refund_method = $_REQUEST['refund_option'];
//$return_shipping_option = $_REQUEST['return_shipping_option'];


//Setup Response HTML...
echo '<html>
      <head>
        <title>Add Item</title>
      </head>
      <body>';

echo '<div id="status">
        <h1 id="lStatus"></h1>
      </div>';

echo '<div id="errors" style="padding:10px;background:rgba(255,49,3,0.5);">
        <h3 style=""><u>Required Edits [These must be corrected for the item to be listed]:</u></h3>
      </div>';

echo '<div id="warnings" style="padding:10px;background:rgba(255,251,0,0.5);">
        <h3 style=""><u>Suggested Edits:</u></h3>
      </div>';

echo '<div id="success" style="padding:10px;background:rgba(92,184,92,0.5);">
        <h3 style=""><u>Success Messages:</u></h3>
      </div>';

//Echo Ending HTML...
  echo '<div id="success_btns" style="width:100%;text-align:center;display:none;">
        <br><br>
        <a href="http://' . $_SERVER['HTTP_HOST'] . '/assets/php/refresh-token-test.php" style="background:blue;padding:10px;border-radius:25px;color:white;">Continue</a>
        <br><br><br><br><br><br>
        <a href="http://' . $_SERVER['HTTP_HOST'] . '/assets/php/refresh-token-test.php?retry=Yes" style="background:green;padding:10px;border-radius:25px;color:white;">Similar Item</a>
      </div>';

echo '<div id="failed_btns" style="width:100%;text-align:center;display:none;">
        <br><br>
        <a href="http://' . $_SERVER['HTTP_HOST'] . '/assets/php/refresh-token-test.php?retry=Yes" style="background:blue;padding:10px;border-radius:25px;color:white;">Retry</a>
      </div>';

//Store or Update the UPC Data from Listing Submission...
//error_reporting(E_ALL);
//include '../store/save-upc-submit.php';
//error_reporting(0);

$request_data = json_encode($_REQUEST);

//Submit to Ebay if turned on...
if($_REQUEST['submit_to_ebay'] == 'on'){
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
if($_REQUEST['import_ebay_listing'] == ''){
  $request = new Types\AddFixedPriceItemRequestType();
}else{
  $request = new Types\ReviseFixedPriceItemRequestType();
}
  

  
/**
 * An user token is required when using the Trading service.
 */
//$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
//$request->RequesterCredentials->eBayAuthToken = $config[$env_mode]['authToken'];

/**
 * Begin creating the fixed price item.
 */
$item = new Types\ItemType();
  
if($_REQUEST['import_ebay_listing'] != ''){
  /**
   * Tell eBay which item we are revising.
   */
  $item->ItemID = $_REQUEST['import_ebay_listing'];
}  
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
  
//$item->Title = $product_section . ' ' . $product_brand . ' ' . $product_title . ' ' . $product_color . ' ' . $product_size;
$item->Title = substr($product_section . ' ' . $product_brand . ' ' . $product_title . ' ' . $product_color . ' ' . $product_size, 0, 80);
 
//$item->Title = $product_title;
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

//Material Item Specific...
//Item Custom Label...
$specific = new Types\NameValueListType();
$specific->Name = 'Color';
$specific->Value[] = $product_color;
$item->ItemSpecifics->NameValueList[] = $specific;

//Size Item Specific...
//Item Custom Label...
$specific = new Types\NameValueListType();
$specific->Name = 'Size';
$specific->Value[] = $product_size;
$item->ItemSpecifics->NameValueList[] = $specific;
  
//Size Item Specific...
//Item Custom Label...
$specific = new Types\NameValueListType();
$specific->Name = 'Type';
$specific->Value[] = $product_Type;
$item->ItemSpecifics->NameValueList[] = $specific;

if($product_section == 'Mens'){
  $specific = new Types\NameValueListType();
  $specific->Name = 'Size (Men\'s)';
  $specific->Value[] = $product_size;
  $item->ItemSpecifics->NameValueList[] = $specific;
}elseif($product_section == 'Womens'){
  $specific = new Types\NameValueListType();
  $specific->Name = 'Size (Women\'s)';
  $specific->Value[] = $product_size;
  $item->ItemSpecifics->NameValueList[] = $specific;
}

$is_array = explode(',',$_REQUEST['item_specifics_array']);
foreach($is_array as $is){
    if($_REQUEST['product_'.$is] != ''){
        $specific = new Types\NameValueListType();
        $specific->Name = str_replace('_',' ',$is);
        $specific->Value[] = $_REQUEST['product_'.$is];
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
$item->DispatchTimeMax = 1;

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
if($_REQUEST['import_ebay_listing'] == ''){
  $response = $service->addFixedPriceItem($request);
}else{
  $response = $service->reviseFixedPriceItem($request);
}

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
                h4.innerHTML = "' . mysqli_real_escape_string($conn, $error->LongMessage) . '";
                errors.appendChild(h4);
              </script>';
      }elseif($error_type == 'Warning'){
        echo '<script>
                var warnings = document.getElementById("warnings");
                var h4 = document.createElement("h4");
                h4.innerHTML = "' . mysqli_real_escape_string($conn, $error->LongMessage) . '";
                warnings.appendChild(h4);
              </script>';
      }
    }
}
if ($response->Ack !== 'Failure') {
    $ebay_item_id = $response->ItemID;
    echo '<script>';
    if($_REQUEST['import_ebay_listing'] != ''){
      echo 'document.getElementById("lStatus").innerHTML += " <span style=\"color:green;\">Ebay Store: REVISED <a href=\"https://www.ebay.com/itm/' . $response->ItemID . '\" target=\"_blank\">[Item#: ' . $response->ItemID . ']</a></span><br><br>";';
    }else{
      echo 'document.getElementById("lStatus").innerHTML += " <span style=\"color:green;\">Ebay Store: LISTED <a href=\"https://www.ebay.com/itm/' . $response->ItemID . '\" target=\"_blank\">[Item#: ' . $response->ItemID . ']</a></span><br><br>";';
    }
            //document.getElementById("lStatus").innerHTML += " <span style=\"color:green;\">Ebay Store: LISTED <a href=\"https://www.ebay.com/itm/' . $response->ItemID . '\" target=\"_blank\">[Item#: ' . $response->ItemID . ']</a></span><br><br>";
    echo 'document.getElementById("success_btns").style.display = "inline-block";
          document.getElementById("failed_btns").style.display = "none";
        </script>';
  
    $iq = "INSERT INTO `upc_search_log` 
      (`date`,`time`,`log_type`,`upc_code`,`data_found`,`listed`,`listing_data`,`request_data`,`user_id`,`user_name`,`inactive`)
      VALUES
      (CURRENT_DATE,CURRENT_TIME,'Listing_Ebay','" . mysqli_real_escape_string($conn,$product_code) . "','N/A','Yes','" . mysqli_real_escape_string($conn,$response) . "','" . mysqli_real_escape_string($conn, $request_data) . "','" . $_SESSION['user_id'] . "','" . $_SESSION['user_name'] . "','No')";
    mysqli_query($conn, $iq);
}else{
    echo '<script>
            document.getElementById("lStatus").innerHTML += " <span style=\"color:red;\">Ebay Store: NOT LISTED</span><br><br>";
            document.getElementById("success_btns").style.display = "none";
            document.getElementById("failed_btns").style.display = "inline-block";
          </script>';
  
  $iq = "INSERT INTO `upc_search_log` 
      (`date`,`time`,`log_type`,`upc_code`,`data_found`,`listed`,`listing_data`,`request_data`,`user_id`,`user_name`,`inactive`)
      VALUES
      (CURRENT_DATE,CURRENT_TIME,'Listing_Ebay','" . mysqli_real_escape_string($conn,$product_code) . "','N/A','No','" . mysqli_real_escape_string($conn,$response) . "','" . mysqli_real_escape_string($conn, $request_data) . "','" . $_SESSION['user_id'] . "','" . $_SESSION['user_name'] . "','No')";
    mysqli_query($conn, $iq);
}

  
}//End Submit to Ebay...


//Submit to Store if turned on...
if($_REQUEST['submit_to_store'] == 'on'){
  include 'http://beta.81outfitters.com/api/connection.php';
  include 'add-to-store-api.php';
  
  if($store_response->response == 'GOOD'){
    
     echo '<script>';
        //if($_REQUEST['import_ebay_listing'] == ''){
          echo 'document.getElementById("lStatus").innerHTML += " <span style=\"color:green;\">81O Store: LISTED <a href=\"http://beta.81outfitters.com/index.php?route=product/product&product_id=' . $store_response->product_id . '\" target=\"_blank\">[Item#: ' . $store_response->product_id . ']</a></span><br><br>";';
        //}else{
        //  echo 'document.getElementById("lStatus").innerHTML += " <span style=\"color:green;\">81O Store: ITEM ALREADY EXISTS <a href=\"http://beta.81outfitters.com/index.php?route=product/product&product_id=' . $store_response->product_id . '\" target=\"_blank\">[Item#: ' . $store_response->product_id . ']</a></span><br><br>";';
        //}
      echo 'document.getElementById("success_btns").style.display = "inline-block";
            document.getElementById("failed_btns").style.display = "none";
            var warnings = document.getElementById("success");
            var h4 = document.createElement("h4");
            h4.innerHTML = "' . $store_response->message . '";
            warnings.appendChild(h4);
          </script>';
  
    $iq = "INSERT INTO `upc_search_log` 
      (`date`,`time`,`log_type`,`upc_code`,`data_found`,`listed`,`listing_message`,`listing_data`,`request_data`,`user_id`,`user_name`,`inactive`)
      VALUES
      (CURRENT_DATE,CURRENT_TIME,'Listing_Store','" . mysqli_real_escape_string($conn,$product_code) . "','N/A','Yes','" . $store_response->message . "','" . mysqli_real_escape_string($conn,$store_response) . "','" . mysqli_real_escape_string($conn, $request_data) . "','" . $_SESSION['user_id'] . "','" . $_SESSION['user_name'] . "','No')";
    mysqli_query($conn, $iq);
    
  }else{
    echo '<script>
            document.getElementById("lStatus").innerHTML += " <span style=\"color:red;\">81O Store: NOT LISTED</span><br><br>";
            document.getElementById("success_btns").style.display = "none";
            document.getElementById("failed_btns").style.display = "inline-block";
            var errors = document.getElementById("errors");
            var h4 = document.createElement("h4");
            h4.innerHTML = "' . $store_response->message . '";
            errors.appendChild(h4);
          </script>';
  
  $iq = "INSERT INTO `upc_search_log` 
      (`date`,`time`,`log_type`,`upc_code`,`data_found`,`listed`,`listing_message`,`listing_data`,`request_data`,`user_id`,`user_name`,`inactive`)
      VALUES
      (CURRENT_DATE,CURRENT_TIME,'Listing_Store','" . mysqli_real_escape_string($conn,$product_code) . "','N/A','No','" . $store_response->message . "','" . mysqli_real_escape_string($conn,$store_response) . "','" . mysqli_real_escape_string($conn, $request_data) . "','" . $_SESSION['user_id'] . "','" . $_SESSION['user_name'] . "','No')";
    mysqli_query($conn, $iq);
    
  }
  
}//End Submit to Store...


/**
 * Set Form Data to SESSION Variable
**/
$_SESSION['form_data'] = $_REQUEST;
  


echo '</body>
      </html>';
