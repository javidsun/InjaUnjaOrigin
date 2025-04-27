<?php

namespace App\Http\Middleware;

use App\Domain\Services\Auth\AuthServicesContract;
use App\Factories\AuthServiceFactory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Middleware;

class AuthTokenMiddleware extends Middleware
{

    public function __construct(protected AuthServiceFactory $authServiceFactory)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        // Usa la factory per creare il servizio corretto basato sul tipo di autenticazione
        Log::info('AuthService Middleware - Start');

        $authService = $this->authServiceFactory->make($request);

        // Aggiungi il servizio alla richiesta in modo che sia accessibile dal controller
        //$request->attributes->set('authService', $authService);

        return $next($request);
    }
    public function handle2(Request $request, Closure $next)
    {
        // Ottieni il servizio di autenticazione dalla Factory
        //$authService = $this->authServiceFactory::make($request);
        $authService = app(AuthServicesContract::class);


        // Aggiungi il servizio alla richiesta in modo che sia accessibile dal controller
        $request->attributes->set('authService', $authService);

        return $next($request);
    }
}
