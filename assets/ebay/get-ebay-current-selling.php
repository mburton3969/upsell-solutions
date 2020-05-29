<?php
header('Content-Type: application/json');
include '../php/connection.php';
error_reporting(0);
session_start();
$env_mode = $_SESSION['ebay_mode'];
$env_mode_val = $_SESSION['ebay_mode_val'];
/**
 * Copyright 2017 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
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
$request = new Types\GetMyeBaySellingRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config[$env_mode]['oauthUserToken'];

/**
 * Request that eBay returns the list of actively selling items.
 * We want 10 items per page and they should be sorted in descending order by the current price.
 */
$request->ActiveList = new Types\ItemListCustomizationType();
$request->ActiveList->Include = true;
$request->ActiveList->Pagination = new Types\PaginationType();
$request->ActiveList->Pagination->EntriesPerPage = 100;
$request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$pageNum = 1;
$item_count = 1;
$i = 0;
do {
    $x->response = 'GOOD';
    $request->ActiveList->Pagination->PageNumber = $pageNum;

    /**
     * Send the request.
     */
    $response = $service->getMyeBaySelling($request);

    /**
     * Output the result of calling the service operation.
     */
    //echo "==================\nResults for page $pageNum\n==================\n";

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

    if ($response->Ack !== 'Failure' && isset($response->ActiveList)) {
      
        foreach ($response->ActiveList->ItemArray->Item as $item) {
            /*printf(
                "(%s) %s: %s %.2f\n",
                $item->ItemID,
                $item->Title,
                $item->SellingStatus->CurrentPrice->currencyID,
                $item->SellingStatus->CurrentPrice->value
            );*/
          //Check if item exists in 81O Website...
          //$exists = file_get_contents('http://beta.81outfitters.com/api/get-product-info.php?api_key=&upc=')
          //Setup Response JSON Data...
          //$x->item[$i]->item_data = json_decode($item);
          //$x->item[$i]->itemID = $item->ItemID;
          //$x->item[$i]->title = $item->Title;
          //$x->item[$i]->iid = $i;
          //$x->item[$i]->itemStatus = $item->ListingStatus;
          
          //$pic_data = file_get_contents('http://beta.reseller-solutions.com/assets/ebay/get-ebay-listing-by-id.php?iid=' . $x->item[$i]->itemID);
          //$pic_data = json_decode($pic_data->item_data);
          //$x->item[$i]->pic_data = $pic_data->PictureURL[0];
          //$x->item[$i]->pic_data = json_decode($pic_data);
          
          $icq = "SELECT * FROM `ebay_imports` WHERE `inactive` != 'Yes' AND `listing_id` = '" . $item->ItemID . "'";
          $icg = mysqli_query($conn, $icq) or die($conn->error);
          if(mysqli_num_rows($icg) <= 0 && $item_count <= 6){
            //Setup Response JSON Data...
            $x->item[$i]->item_data = json_decode($item);
            $x->item[$i]->itemID = $item->ItemID;
            $x->item[$i]->title = $item->Title;
            $x->item[$i]->iid = $i;
            $item_count += 1;
            $i++;
          }
          
          
        }
    }

    $pageNum += 1;

//} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
} while (isset($response->ActiveList) && $item_count <= 6);
  
$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;