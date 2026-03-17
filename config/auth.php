<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
            'hash' => false,
        ],

        // Guard para usuários comuns
        'regular' => [
            'driver' => 'session',
            'provider' => 'regular_users', // Este provider precisa existir
        ],

        // Guard para ONGs
        'ong' => [
            'driver' => 'session',
            'provider' => 'ongs', // Este provider precisa existir
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Todos os providers listados aqui precisam ter um modelo associado
    |
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Provider para usuários comuns (NOVO)
        'regular_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\RegularUser::class,
        ],

        // Provider para ONGs (NOVO)
        'ongs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Ong::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Password reset para usuários comuns
        'regular_users' => [
            'provider' => 'regular_users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Password reset para ONGs
        'ongs' => [
            'provider' => 'ongs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];