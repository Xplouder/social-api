<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '211435542601552',
        'client_secret' => '33ffa57bc3ffa56040a7bb61dba9d0af',
        'redirect' => "http://192.168.10.10/api/v1/auth/facebook/callback",
    ],

    'google' => [
        'client_id' => '773469737134-9u15pkcr1bl0103p4g3i10lqc275vvrg.apps.googleusercontent.com',
        'client_secret' => 'lFiNB49ZQrCdX_ruprHgYC9V',
        'redirect' => "http://api.dev/api/v1/auth/google/callback",
    ],

];
