<?php
include 'ebay-token.php';
/**
 * Configuration settings used by all of the examples.
 *
 * Specify your eBay application keys in the appropriate places.
 *
 * Be careful not to commit this file into an SCM repository.
 * You risk exposing your eBay application keys to more people than intended.
 */
if($_SERVER['HTTP_HOST'] == 'beta.reseller-solutions.com'){
  //BETA Credentials...
  return [
      'sandbox' => [
          'credentials' => [
              'devId' => 'f73f23b1-8af0-4d00-9124-d5f52445b6fe',
              'appId' => 'MichaelB-Reseller-SBX-719766d65-d15fb489',
              'certId' => 'SBX-19766d65a56b-11f7-43a1-8edd-2df6',
          ],
          'authToken' => $_SESSION['app_token'],
          'oauthUserToken' => $_SESSION['user_token'],
          'ruName' => 'Michael_Burton-MichaelB-Resell-zwzrq'
      ],
      'production' => [
          'credentials' => [
              'devId' => 'f73f23b1-8af0-4d00-9124-d5f52445b6fe',
              'appId' => 'MichaelB-Reseller-PRD-a19766d65-dc5c1ee3',
              'certId' => 'PRD-19766d658049-db9d-4b95-8f8e-4fb9',
          ],
          'authToken' => $_SESSION['app_token'],
          'oauthUserToken' => $_SESSION['user_token'],
          'ruName' => 'Michael_Burton-MichaelB-Resell-labxymz'
      ]
  ];
  
}else{
  //LIVE Credentials...
  return [
      'sandbox' => [
          'credentials' => [
              'devId' => '18a9344d-9393-4dab-95d6-bf6c593688b9',
              'appId' => 'MichaelB-UpsellSo-SBX-9dbf9000b-ae4101bc',
              'certId' => 'SBX-dbf9000ba154-2b75-45b2-80f1-ca34',
          ],
          'authToken' => $_SESSION['app_token'],
          'oauthUserToken' => $_SESSION['user_token'],
          'ruName' => 'Michael_Burton-MichaelB-Upsell-gzpwqabnj'
      ],
      'production' => [
          'credentials' => [
              'devId' => '18a9344d-9393-4dab-95d6-bf6c593688b9',
              'appId' => 'MichaelB-UpsellSo-PRD-b520c1333-d6a63876',
              'certId' => 'PRD-520c13336bb5-2cc4-4f3a-9031-dab8',
          ],
          'authToken' => $_SESSION['app_token'],
          'oauthUserToken' => $_SESSION['user_token'],
          'ruName' => 'Michael_Burton-MichaelB-Upsell-sprmo'
      ]
  ];
  
}