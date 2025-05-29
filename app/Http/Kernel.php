<?php

namespace App\Http;

use Symfony\Component\HttpKernel\HttpKernel;

class Kernel extends HttpKernel
{
    protected array $middleware = [];

    protected array $middlewareGroups = [
        // TODO JAVID : backed route da mettere a posto creazione di constant pattern e key e documentazione per ogni di questi middleware
        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api', //sanctum
            \Illuminate\Routing\Middleware\SubstituteBindings::class, //sanctum
        ],
        // TODO JAVID : frontend route da mettere a posto creazione di constant pattern e key e documentazione per ogni di questi middleware
        'web' => [
            \App\Http\Middleware\CustomVerifyCsrfToken::class,
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'role_or_permission' => \App\Http\Middleware\EnsureUserHasRoleOrPermission::class,

        ],
    ];

    protected array $routeMiddleware = [
    ];
}
