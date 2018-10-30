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
    ],
    'activity' => [
        'valid_pause'   => 100,
        'level_points'  => 10,
        'dromp_limit'   => 60,
        'period'        => 60,
    ],
];
