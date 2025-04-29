<?php

namespace App\Services\AuthServices;

use App\Constant\TableParametersConst\AuthConst\SocialiteDeriveConst;
use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Services\Auth\AuthServicesContract;
use App\Domain\Services\AuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User as SocialUser;

class OAuthServiceWithSocialite extends AuthService implements AuthServicesContract
{
    public function __construct(
    ) {
        Parent::__construct();
    }

    public function loginWithOAuth(SocialUser $socialUser, string $socialProvider): JsonResponse
    {
        $socialId =match($socialProvider) {
            SocialiteDeriveConst::GOOGLE => UserJson::GOOGLE_ID,
            SocialiteDeriveConst::FACEBOOK => UserJson::FACEBOOK_ID,
            SocialiteDeriveConst::TWITTER => Userjson::TWITTER_ID,
            SocialiteDeriveConst::APPLE => Userjson::APPLE_ID,
            default => new \Exception('not supported provider'),
        };
        $user = User::updateOrCreate(
            [$socialId => $socialUser->getId()],
            [
                UserJson::NAME => $socialUser->getName(),
                UserJson::EMAIL => $socialUser->getEmail(),
                UserJson::PASSWORD => bcrypt(str()->random(12)),
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            UserJson::SUCCESS => true,
            UserJson::MESSAGE => 'Login effettuato con Google',
            UserJson::USER => [
                UserJson::ID => $user->id,
                UserJson::NAME => $user->name,
                UserJson::EMAIL => $user->email,
            ],
            UserJson::TOKEN => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        // TODO: Implement logout() method.
    }
}
