<?php

return [

    'app_id' => env('GEOCODER_APP_ID', ''),
    'app_code' => env('GEOCODER_APP_CODE', ''),

    'url' => 'https://geocoder.api.here.com/6.2/geocode.json',

    'parameters' => [
        'country' => 'SVK',
        'countryfocus' => 'SVK',
        'jsonattributes' => 1,
        'maxresults' => 1,
    ],

];
