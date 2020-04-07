<?php

use App\Entity\User\User;

return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'vkontakte' => [
        'client_id' => env('VKONTAKTE_KEY'),
        'client_secret' => env('VKONTAKTE_SECRET'),
        'redirect' => env('VKONTAKTE_REDIRECT_URI')
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_KEY'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI')
    ],

    'odnoklassniki' => [
        'client_id' => env('ODNOKLASSNIKI_ID'),
        'client_secret' => env('ODNOKLASSNIKI_SECRET'),
        'client_public' => env('ODNOKLASSNIKI_PUBLIC'),
        'redirect' => env('ODNOKLASSNIKI_REDIRECT'),
    ],

    'image_resizer' => [
        'quality' => 60
    ],

    'yandex_kassa' => [
        'shop_id' => env('YANDEX_KASSA_SHOP_ID'),
        'secret_key' => env('YANDEX_KASSA_SECRET_KEY'),
        'proxy' => env('YANDEX_KASSA_PROXY')
    ],

    'elasticsearch' => [
        'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
        'retries' => 1,
    ],

    'ip' => [
        'driver' => 'ipstack',
        'ipstack' => [
            'key' => env('IP_STACK_KEY'),
            'secure' => false,
        ],
    ],

    'userecho' => [
        'enabled' => env('USER_ECHO_ENABLED', false),
        'host' => env('USER_ECHO_HOST'),
        'sso_key' => env('USER_ECHO_SSO_KEY')
    ]

];
