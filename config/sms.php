<?php

return [
    'send_config' => [
        'timeout' => 5.0,
        'default' => [
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,
            'gateways' => ['aliyun'],
        ],
        'gateways' => [
            'aliyun' => [
                'access_key_id' => env('SMS_ID'),
                'access_key_secret' => env('SMS_KEY'),
                'sign_name' => env('SMS_SIGN')
            ]
        ]
    ],
    'templates' => [
        'register' => env('SMS_REGISTER'),
    ],
    'send_max' => env('SMS_SEND_MAX', 20),
];