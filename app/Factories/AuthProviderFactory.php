<?php

namespace App\Factories;

use App\Constant\Types\AuthenticationType;
use App\Domain\Services\Auth\RegisterStrategyContract;
use App\Services\AuthServices\AuthTraditionalServices;
use App\Services\AuthServices\OAuthServiceWithSocialite;

class AuthProviderFactory
{
    public function make(string $provider): RegisterStrategyContract
    {
        return match ($provider) {
            AuthenticationType::TRADITIONAL => app(AuthTraditionalServices::class),
            AuthenticationType::GOOGLE, AuthenticationType::APPLE => app(OAuthServiceWithSocialite::class),
            default => throw new \InvalidArgumentException('Provider non supportato')
        };
    }
}
