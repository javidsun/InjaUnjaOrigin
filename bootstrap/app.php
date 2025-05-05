<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        /**
         * $middleware->web(prepend: [
         * \Illuminate\Session\Middleware\StartSession::class, // Gestisce le sessioni
         * \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Condivide gli errori di validazione
         * \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // Protezione CSRF
         * \Illuminate\Routing\Middleware\SubstituteBindings::class, // Risolve i parametri delle route
         * ]);
         *
         * $middleware->web(append: [
         * \App\Http\Middleware\HandleInertiaRequests::class, // Gestisce le richieste Inertia.js
         * ]);
 */
        /**
         * $middleware->api(prepend: [
         * \Illuminate\Routing\Middleware\SubstituteBindings::class, // Risolve i parametri delle route
         * \Illuminate\Auth\Middleware\Authenticate::class, // Richiede autenticazione (se usi Sanctum)
         * ]);
         *
         * $middleware->api(append: [
         * 'auth:sanctum', // Protegge le API con autenticazione a token
         * 'throttle:60,1', // Limita il numero di richieste API (60/minuto)
         * ]);
 */
        // Middleware per le route web (Inertia.js)
        $middleware->web(append: [\App\Http\Middleware\HandleInertiaRequests::class]);
        // Middleware per le API (Protezione e throttling)
        //Protegge le API e richiede autenticazione con un token
        //$middleware->api(prepend: ['auth:sanctum']);
        //Limita le richieste API per prevenire abusi
        //$middleware->api(append: ['throttle:60,1']);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
