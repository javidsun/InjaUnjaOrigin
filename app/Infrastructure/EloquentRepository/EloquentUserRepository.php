<?php

namespace App\Infrastructure\EloquentRepository;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Entities\UserEntity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        return User::where('provider', $provider)
            ->where('provider_id', $providerId)->first()
            ->toEntity();
    }

    public function get(array $data): UserEntity
    {
        $userModel = User::where('provider', $data['provider'])
            ->where('email', $data['email'])
            ->first();

        if (!$userModel) {
            Log::warning('Utente non trovato con email: ' . $data['email']);
            throw new NotFoundHttpException('Utente non trovato.');
        }

        if ($data['provider'] === UserJson::TRADITIONAL && !Hash::check($data['password'], $userModel->password)) {
            Log::warning('Password errata per utente con email: ' . $data['email']);
            throw new UnauthorizedHttpException('', 'Password non corretta.');
        }

        return $userModel->toEntity();
    }
}
