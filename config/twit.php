<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Twitter client apps
    |--------------------------------------------------------------------------
    */
    'apps' => [

        /*
        |--------------------------------------------------------------------------
        | App 01
        |--------------------------------------------------------------------------
        */
        'app01' => [
            'consumer_key' => env('TWITTER_APP01_CONSUMERKEY', ''),
            'consumer_secret' => env('TWITTER_APP01_CONSUMERSECRET', ''),
            'access_token' => env('TWITTER_APP01_ACCESSTOKEN', ''),
            'access_token_secret' => env('TWITTER_APP01_ACCESSTOKENSECRET', ''),
        ],

    ],

];
