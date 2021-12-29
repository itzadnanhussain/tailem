<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => '1106211260232848',
        'client_secret' => 'c62ebb0fe1eada3b96b5abf311728ffa',
        'redirect' => 'http://tailem.com.au/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '812587052528-sjag3dondkk3d4rqt5rnku5h12eiobs9.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://tailem.com.au/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => 'xxxx',
        'client_secret' => 'xxxxx',
        'redirect' => 'http://tailem.com.au/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => 'xxxxxx',
        'client_secret' => 'xxxxxx',
        'redirect' => 'http://tailem.com.au/auth/google/callback',
    ],


];
