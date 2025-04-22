<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class CustomVerifyCsrfToken extends Middleware
{
    /**
     * Gli URL che devono essere esclusi dalla protezione CSRF.
     *
     * @var array
     */
    protected $except = [
        'api/*', // ✅ Esclude tutte le API dalla protezione CSRF
    ];
}
