<?php

return [

    'client_key' => env('SHOPIFY_KEY'),
    'client_secret' => env('SHOPIFY_SECRET'),

    'redirect_uri' => env('APP_URL').'/shopify/register',
    
    'scope' => [
        'read_products',
        'read_orders',
    ],

];