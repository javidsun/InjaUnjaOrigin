<?php

namespace App\Domain\Repositories;

use App\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function save(UserEntity $user): UserEntity;

    public function findByProvider(string $provider, string $providerId): ?UserEntity;

    public function get(array $data): UserEntity;
}
