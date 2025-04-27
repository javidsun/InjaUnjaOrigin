<?php

namespace App\Domain\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialUser;


interface AuthServicesContract
{
    public function loginWithOAuth(SocialUser $socialUser , string $socialProvider):JsonResponse;
    public function logout(Request $request):JsonResponse;

}
