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
            'devId' => 'YOUR_PRODUCTION_DEVID_APPLICATION_KEY',
            'appId' => 'YOUR_PRODUCTION_APPID_APPLICATION_KEY',
            'certId' => 'YOUR_PRODUCTION_CERTID_APPLICATION_KEY',
        ],
        'authToken' => 'YOUR_PRODUCTION_USER_TOKEN_APPLICATION_KEY',
        'oauthUserToken' => 'YOUR_PRODUCTION_OAUTH_USER_TOKEN',
        'ruName' => 'YOUR_PRODUCTION_RUNAME'
    ]
];