<?php
return [
    'enable'           => env('RECAPTCHA_ENABLED', true),
    'site_key'         => env('RECAPTCHA_SITE_KEY', ''),
    'secret_key'       => env('RECAPTCHA_SECRET_KEY', ''),
    'input_name'       => env('RECAPTCHA_INPUT_NAME', 'g-recaptcha-response'),
    'response_code'    => env('RECAPTCHA_RESPONSE_CODE', 401),
    'response_message' => env('RECAPTCHA_RESPONSE_MESSAGE', 'Google ReCaptcha Verify Fails'),
    'ip_check_enabled' => env('RECAPTCHA_IP_CHECK_ENABLED', true),
    'custom_host'      => env('RECAPTCHA_CUSTOM_HOST', null),
];
