<?php
header('Content-Type: application/json');
error_reporting(0);
session_start();$env_mode = $_SESSION['ebay_mode'];
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
$request->ActiveList->Pagination->EntriesPerPage = 10;
$request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$pageNum = 1;
$i = 0;
do {
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
          $x->item[$i]->item_data = json_decode($item);
          $x->item[$i]->itemID = $item->ItemID;
          $x->item[$i]->title = $item->Title;
          $x->item[$i]->iid = $i;
          //$x->item[$i]->itemStatus = $item->ListingStatus;
          $i++;
        }
    }

    $pageNum += 1;

//} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
} while (isset($response->ActiveList) && $pageNum <= 1);
  
$res = json_encode($x, JSON_PRETTY_PRINT);
echo $res;