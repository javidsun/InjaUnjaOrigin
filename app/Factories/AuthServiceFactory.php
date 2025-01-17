<?php

namespace App\Factories;

use App\Services\AuthServices\AuthServicesWithAppleAccount;
use App\Services\AuthServices\AuthServicesWithFacebook;
use App\Services\AuthServices\AuthServicesWithGoogleAccount;
use App\Services\AuthServices\AuthServicesWithPassword;
use App\Services\AuthServices\AuthServicesWithTwitter;
use App\Services\IService\AuthServicesContract;
use Illuminate\Http\Request;
use ReflectionClass;


class AuthServiceFactory
{
    /*protected array $services = [
        'password' => AuthServicesWithPassword::class, // constant pattern, o direttamente il tipo di richiesta PasswordAuthenticationRequest::Class
        'apple' => AuthServicesWithAppleAccount::class,
        'google' => AuthServicesWithGoogleAccount::class,
        'twitter' => AuthServicesWithTwitter::class,
        'facebook' => AuthServicesWithFacebook::class,
    ];*/

    public static function make(Request $request): AuthServicesContract
    {
        return match (true) {
            $request->has('facebook_token') => app(AuthServicesWithFacebook::class),
            $request->has('google_token') => app(AuthServicesWithGoogleAccount::class),
            $request->has('apple_token') => app(AuthServicesWithAppleAccount::class),
            $request->has('twitter_token') => app(AuthServicesWithTwitter::class),
            default => app(AuthServicesWithPassword::class), // Usa password come default
        };
    }

    public function make2(Request $request):AuthServicesContract
    {
        $authType = $request->input('auth_type','password');
        if(array_key_exists($authType, $this->services)){
            $serviceClass = $this->services[$authType];

            $serviceInstance = app($serviceClass);

            if ($serviceInstance instanceof AuthServicesContract) {
                return $serviceInstance;
            }
            //$reflectionClass = new ReflectionClass($serviceClass);

            /*if ($reflectionClass->isInstantiable() && $reflectionClass->implementsInterface(AuthServicesContract::class)){
                return app($serviceClass);
            }*/
        }
        return app(AuthServicesWithPassword::class);
    }

}
