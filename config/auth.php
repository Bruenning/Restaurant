<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
        'driver' => 'passport',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false,
        ],

        'reservation' => [
            'driver' => 'passport',
            'provider' => 'reservations',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'reservations' => [
            'driver' => 'eloquent',
            'model' => App\Models\Reservation::class,
        ],
    ],
];
