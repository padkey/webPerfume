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
    'google' => [
        'client_id' => '32225103337-u05idivnjfikfb2h3l50j5cql7s1gu16.apps.googleusercontent.com',
        'client_secret' => 'AdF30wcwYj6__DGITXhZuB-F',
        'redirect' => 'http://localhost:8080/shopperfume/google/callback'
    ],
    'facebook'=>[
        'client_id'=>'496390685040946',
        'client_secret'=>'ced69ee914f7a67a8f2bc9dcbba7ec5f',
        'redirect'=>'http://localhost:8080/shopperfume/admin/callback'
    ]


];
