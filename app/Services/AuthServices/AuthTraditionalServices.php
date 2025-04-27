<?php

namespace App\Services\AuthServices;

use App\Constant\AuthConst\UserJson;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\AuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthTraditionalServices extends AuthService
{
    public function __construct() {
        parent::__construct();
    }


    public function login(string $emailValidated , string $passwordValidated): JsonResponse
    {
        $user = User::where(UserJson::EMAIL, $emailValidated)->first();

        if (!$user || !Hash::check($passwordValidated, $user->password)) {
            return response()->json([UserJson::MESSAGE => 'Credenziali non valide'], 401);
        }
        $token = $user->createToken('auth_token');
        Log::info('token sarebbe '.var_export($token, true));

        return response()->json([
            UserJson::SUCCESS => true,
            UserJson::MESSAGE => 'Login effettuato con successo',
            UserJson::USER => [
                UserJson::ID => $user->id,
                UserJson::EMAIL => $user->email,
            ],
            UserJson::TOKEN => $token->plainTextToken,
        ], 200);
    }
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout effettuato con successo']);
    }
}
