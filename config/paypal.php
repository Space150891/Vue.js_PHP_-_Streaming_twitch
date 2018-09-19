<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'username'    => env('PAYPAL_SANDBOX_API_USERNAME', ''),
        'password'    => env('PAYPAL_SANDBOX_API_PASSWORD', ''),
        'secret'      => env('PAYPAL_SANDBOX_API_SECRET', ''),
        'certificate' => env('PAYPAL_SANDBOX_API_CERTIFICATE', ''),
        'app_id'      => 'APP-80W284485P519543T', // Used for testing Adaptive Payments API in sandbox mode
    ],
    'live' => [
        'username'    => env('PAYPAL_LIVE_API_USERNAME', ''),
        'password'    => env('PAYPAL_LIVE_API_PASSWORD', ''),
        'secret'      => env('PAYPAL_LIVE_API_SECRET', ''),
        'certificate' => env('PAYPAL_LIVE_API_CERTIFICATE', ''),
        'app_id'      => '', // Used for Adaptive Payments API
    ],
    'redirect_url'   => env('PAYPAL_REDIRECT'),
    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'USD'),
    'notify_url'     => '', // Change this accordingly for your application.
    'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => true, // Validate SSL when creating api client.
    'buttons'       => [
        'b1'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SKX3QQBP6RXTA',
        'b3'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=N3HRX4MHNFRB8',
        'b6'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F3EBVZERHWQ3U',
        'b12'       => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GHK3WH6A2NR7E',
        'a1'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=U468E6XJNQZ4A',
        'a3'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YBBVHNHBH7V6U',
        'a6'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QQJHGH269AEEU',
        'a12'       => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QQJHGH269AEEU',
        'g1'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=49RUQXPRFP2T2',
        'g3'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YBBVHNHBH7V6U',
        'g6'        => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XZLKNJVA42NQC',
        'g12'       => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BAMKD3BTKFFSJ',
    ]
];
