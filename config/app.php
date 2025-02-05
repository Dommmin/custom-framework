<?php

return [
    'name' => env('APP_NAME'),
    'debug' => env('APP_DEBUG', false),
    'providers' => [
        Framework\Providers\AppServiceProvider::class,
        Framework\Providers\RequestServiceProvider::class,
        Framework\Providers\RouteServiceProvider::class,
        Framework\Providers\ViewServiceProvider::class,
        Framework\Providers\DatabaseServiceProvider::class,
        Framework\Providers\AuthServiceProvider::class,
        Framework\Providers\CsrfServiceProvider::class,
    ],
];