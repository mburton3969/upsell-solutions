<?php
//header('Content-Type: application/json');
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


echo '  <html>

  <head>
    <link href="../../jquery/jquery-ui.css" rel="stylesheet" />
    <style>
      /* page */

      html {
        font: 16px/1 "Open Sans", sans-serif;
        overflow: auto;
        padding: 0.5in;
      }

      html {
        background: #999;
        cursor: default;
      }

      body {
        box-sizing: border-box;
        min-height: 11in;
        margin: 0 auto;
        overflow: hidden;
        padding: 0.5in;
        width: 8.5in;
      }

      body {
        background: #FFF;
        border-radius: 1px;
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
      }

      th,
      td {
        border: 1px solid black;
        padding: 5px;
      }

      .btn {
        padding-left: 8px;
        padding-right: 8px;
        background: blue;
        border-radius: 25px;
        color: white;
      }

      @media print {
        * {
          -webkit-print-color-adjust: exact;
        }
        html {
          background: none;
          padding: 0;
        }
        body {
          box-shadow: none;
          margin: 0;
        }
        span:empty {
          display: none;
        }
        .add,
        .cut {
          display: none;
        }
      }

      @page {
        margin: 0;
      }
    </style>
  </head>

  <body>
    <h1 style="text-align:center;">
      Inventory Sync Report
    </h1>

    <table id="rec_table" style="/*margin:auto;*/">
      <thead>
        <tr style="background:lightgray;">
          <th>Ebay ID</th>
          <th>81O ID</th>
          <th>Item</th>
          <th>Ebay QOH</th>
          <th>81O QOH</th>
        </tr>
      </thead>
      <tbody>';


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
          if($item_count == 1){
            $xx->data = json_decode($item);
            $rrr = json_encode($xx);
            //echo $rrr;
          }
          //Setup Response JSON Data...
          $x->item[$i]->item_data = json_decode($item);
          $x->item[$i]->itemID = $item->ItemID;
          $x->item[$i]->title = $item->Title;
          $x->item[$i]->iid = $i;
          $item_count += 1;
          $i++;
          
          //Get Item ID for 81O store...
          $iq = "SELECT * FROM `oc_kb_ebay_profile_products` WHERE `ebay_listiing_id` = '" . $item->ItemID . "'";
          $ig = mysqli_query($s_conn, $iq) or die($s_conn->error);
          $ir = mysqli_fetch_array($ig);
          
          //Get QOH...
          $iiq = "SELECT * FROM `oc_product_test` WHERE `product_id` = '" . $ir['id_product'] . "'";
          $iig = mysqli_query($s_conn, $iiq) or die($s_conn->error);
          $iir = mysqli_fetch_array($iig);
          
          if(intval($item->Quantity) != intval($iir['quantity'])){
          echo '<tr>
                  <td>' . $item->ItemID . '</td>
                  <td>' . $iir['product_id'] . '</td>
                  <td>' . $item->Title . '</td>
                  <td>' . $item->Quantity . '</td>
                  <td>' . $iir['quantity'] . '</td>
                </tr>';
          }
          
        }
    }

    $pageNum += 1;

} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
  
//$res = json_encode($x, JSON_PRETTY_PRINT);
//echo $res;



echo '</tbody>
    </table>



  </body>
  <!--JQuery Files-->
  <script src="../../jquery/external/jquery/jquery.js"></script>
  <script src="../../jquery/jquery-ui.js"></script>
  <script>
    $(document).ready(function() {
      $(".date").datepicker();
    });
  </script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script>
    $("#rec_table").dataTable({
      "paging": false
    });
  </script>

  </html>';
?>




