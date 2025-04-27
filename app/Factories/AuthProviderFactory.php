<?php

namespace App\Factories;

use App\Domain\Services\Auth\RegisterStrategyContract;
use App\Services\AuthServices\AuthTraditionalServices;
use App\Services\AuthServices\OAuthServiceWithSocialite;

class AuthProviderFactory
{
    public function make(string $provider): RegisterStrategyContract
    {
        return match($provider) {
            'traditional' => app(AuthTraditionalServices::class),
            'google', 'apple' => app(OAuthServiceWithSocialite::class),
            default => throw new \InvalidArgumentException('Provider non supportato')
        };
    }

}
