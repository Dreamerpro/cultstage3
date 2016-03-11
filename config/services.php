<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '511377382383358',
        'client_secret' => '14c6149df8bee4eca4d5ad23ab63a559',
        'redirect' => 'http://dev.cultstage.com/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '638694339776-j8um54ditdrfkon4if9omdgga3732st4.apps.googleusercontent.com',
        'client_secret' => 'fxgO1jR9EXsH64595gwHM-T7',
        'redirect' => 'http://dev.cultstage.com/auth/google/callback',
    ],

];
