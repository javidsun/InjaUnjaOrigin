<?php

namespace App\Http\Controllers;

use App\Constant\AuthConst\UserJson;
use App\Services\IService\AuthServicesContract;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;

class OAuthController
{

    public function __construct(protected ?AuthServicesContract $authServices = null)
    {
        $this->authServices ??= app(AuthServicesContract::class);
    }

    public function redirect($provider): RedirectResponse
    {
        try {
            return Socialite::driver($provider)->redirect();
        }catch (\Exception $exception){
            return new RedirectResponse($exception->getMessage());
        }
    }

    /**
     * Callback dopo l'autenticazione con il provider.
     */
    public function callback($provider): JsonResponse
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            return $this->authServices->loginWithOAuth($socialUser,$provider);
        } catch (\Exception $e) {
            return response()->json([
                UserJson::SUCCESS => false,
                UserJson::MESSAGE => 'Errore durante il login con ' . ucfirst($provider),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
