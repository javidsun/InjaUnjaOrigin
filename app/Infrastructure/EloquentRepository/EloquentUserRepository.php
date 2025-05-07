<?php

namespace App\Infrastructure\EloquentRepository;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Entities\UserEntity;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
        return User::where('provider', $provider)->where('provider_id', $providerId)->first()->toEntity();
    }

    public function get(array $data): UserEntity
    {
        $user = User::where('provider', $data['provider'])
            ->where('email', $data['email'])
            ->first()
            ->toEntity();
        Log::info('user model sarebbe :'.var_export($user, true));

        return $user;
    }
}
