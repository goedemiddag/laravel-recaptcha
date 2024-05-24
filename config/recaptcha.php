<?php

return [

    'site_key' => env('RECAPTCHA_SITE_KEY'),

    'secret_key' => env('RECAPTCHA_SECRET_KEY'),

    'threshold' => env('RECAPTCHA_THRESHOLD', 0.3),

    'skip_ips' => [
        // 127.0.0.1
    ],

];
