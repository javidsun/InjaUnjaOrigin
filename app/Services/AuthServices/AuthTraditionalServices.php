<?php

namespace App\Services\AuthServices;

use App\Domain\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthTraditionalServices extends AuthService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function logout(Request $request): JsonResponse
    {
        // TODO JAVID : controllare questo funzionamento come sarebbe per il futuro
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout effettuato con successo']);
    }
}
