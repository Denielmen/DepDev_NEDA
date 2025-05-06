<?php

namespace App\Http;

class Kernel
{
    protected $routeMiddleware = [
        // Other middleware...
        'password.setup' => \App\Http\Middleware\CheckPasswordSetup::class,
    ];
}