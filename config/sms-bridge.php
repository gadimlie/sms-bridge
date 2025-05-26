<?php

return [
    'default' => env('SMS_BRIDGE_DEFAULT', 'figensoft'),

    'providers' => [
        'figensoft' => [
            'driver' => \Gadimlie\SmsBridge\Drivers\FigensoftProvider::class,
            'config' => [
                'endpoint' => env('SMS_BRIDGE_ENDPOINT'),
                'username' => env('SMS_BRIDGE_USERNAME'),
                'password' => env('SMS_BRIDGE_PASSWORD'),
            ],
        ],

        'lsim' => [
            'driver' => \Gadimlie\SmsBridge\Drivers\LSimProvider::class,
            'config' => [
                'login' => env('SMS_BRIDGE_USERNAME'),
                'password' => env('SMS_BRIDGE_PASSWORD'),
                'sender' => env('SMS_BRIDGE_SENDER'),
                'endpoint' => env('SMS_BRIDGE_ENDPOINT'),
            ],
        ],

        // 'twilio' => [
        //     'driver' => \Gadimlie\SmsBridge\Drivers\TwilioProvider::class,
        //     'config' => [
        //         'sid'   => env('TWILIO_SID'),
        //         'token' => env('TWILIO_TOKEN'),
        //         'from'  => env('TWILIO_FROM'),
        //     ],
        // ],
    ],
];
