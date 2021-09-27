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
        'client_id' => ' ',
        'client_secret' => ' ',
        'redirect' => 'http://tailem.com.au/auth/facebook/callback',
    ], 
    'google' => [
        'client_id' => '792177933548-co003qp3kj0ephqqei2is5n48riumdka.apps.googleusercontent.com',
        'client_secret' => 'MkVZEI1MuCh5CCru1_3aQCCe',
        'redirect' => 'https://www.tailem.com/sign-in',
    ], 


];
