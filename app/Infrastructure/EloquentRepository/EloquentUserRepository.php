<?php

namespace App\Infrastructure\EloquentRepository;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Entities\UserEntity;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function save(UserEntity $user): UserEntity
    {
        $model = User::fromEntity($user);
        $model->save();
        return $model->toEntity();
    }

    public function findByProvider(string $provider, string $providerId): ?UserEntity
    {
        $user = User::where('provider', $provider)->where('provider_id', $providerId)->first();
        return $user?->toEntity();
    }
}
