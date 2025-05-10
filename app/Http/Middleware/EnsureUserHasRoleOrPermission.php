<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRoleOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $params): Response
    {
        $user = $request->user();
        $items = explode('|', $params); // esempio: "admin|host|create announcement"

        if (! $user) {
            abort(401, 'Utente non autenticato.');
        }

        if ($user->hasAnyRole($items) || $user->hasAnyPermission($items)) {
            return $next($request);
        }

        abort(403, 'Accesso negato.');
    }
}
