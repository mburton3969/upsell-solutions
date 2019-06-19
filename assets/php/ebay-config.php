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
            'devId' => '18a9344d-9393-4dab-95d6-bf6c593688b9',
            'appId' => 'MichaelB-UpsellSo-PRD-b520c1333-d6a63876',
            'certId' => 'PRD-520c13336bb5-2cc4-4f3a-9031-dab8',
        ],
        'authToken' => $_SESSION['app_token'],
        'oauthUserToken' => $_SESSION['user_token'],
        'ruName' => 'Michael_Burton-MichaelB-Upsell-sprmo'
    ]
];