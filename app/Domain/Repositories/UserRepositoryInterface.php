<?php

namespace App\Domain\Repositories;

use App\Entities\UserEntity;
use Laravel\Sanctum\NewAccessToken;

interface UserRepositoryInterface
{
    public function save(UserEntity $user): string;

    public function findByProvider(string $provider, string $providerId): ?UserEntity;

    public function get(array $data): UserEntity;
}
