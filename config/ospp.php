<?php

return [

    'cards' => [
        /*
        * Maximum cards thet Viewer has
        */
        'max'   =>  env('OSPP_CARDS_MAX', 5),
    ],
    'bot'   => [
        'secret_key' => env('OSPP_BOT_SECRET'),
    ]
];
