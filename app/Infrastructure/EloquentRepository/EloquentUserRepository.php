<?php

namespace App\Infrastructure\EloquentRepository;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Entities\UserEntity;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(UserEntity $user): string
    {
        $model = User::fromEntity($user);

        if (!empty(User::where('email', $user->email)->first())) {
            throw new UnauthorizedHttpException(__('User already exists.'));
        }

        $model->save();
        return $model->createToken('auth_token')->plainTextToken;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function login(UserEntity $user): string
    {
        $userModel = User::where('email', $user->email)->first();
        if (!$userModel) {
            throw new \Exception("Utente non trovato");
        }

        if (!Hash::check($user->password, $userModel->password)) {
            throw new \Exception("Password errata.");
        }

        return $userModel->createToken('auth_token')->plainTextToken;
    }

    public function findByProvider(string $provider, string $providerId): ?UserEntity
    {
        return User::where(UserJson::PROVIDER, $provider)
            ->where(UserJson::PROVIDER_ID, $providerId)->first()
            ->toEntity();
    }

    public function get(array $data): UserEntity
    {
        $userModel = User::where(UserJson::PROVIDER, $data[UserJson::PROVIDER])
            ->where(UserJson::EMAIL, $data[UserJson::EMAIL])
            ->first();

        if (! $userModel) {
            Log::warning('Utente non trovato con email: '.$data['email']);
            throw new NotFoundHttpException('Utente non trovato.');
        }

        if ($data[UserJson::PROVIDER] === UserJson::TRADITIONAL && ! Hash::check($data[UserJson::PASSWORD], $userModel->password)) {
            Log::warning('Password errata per utente con email: '.$data['email']);
            throw new UnauthorizedHttpException('', 'Password non corretta.');
        }

        return $userModel->toEntity();
    }
}
