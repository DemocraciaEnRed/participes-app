<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mapbox
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mapbox' => [
        'key' => env('MAPBOX_API_KEY'),
        'style' => env('MAPBOX_MAP_STYLE'),
    ],

];
