<?php

return [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),

    // The threshold to pass the recaptcha validation, from 0 (easiest) to 1 (hardest)
    'threshold' => env('RECAPTCHA_THRESHOLD', 0.3),

    // Provide IP addresses that shouldn't be validated
    'skip_ips' => [
        // 127.0.0.1
    ],
];
