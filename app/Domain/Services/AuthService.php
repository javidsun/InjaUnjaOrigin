<?php

namespace App\Domain\Services;

use App\Domain\Entity;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\Auth\RegisterStrategyContract;
use App\Entities\UserEntity;
use Illuminate\Support\Facades\Log;
use ReflectionException;

abstract class AuthService implements RegisterStrategyContract
{
    public function __construct(
        protected ?UserRepositoryInterface $userRepositoryInterface = null
    ) {
        $this->userRepositoryInterface ??= app(UserRepositoryInterface::class);
    }

    /**
     * @throws ReflectionException
     */
    public function register(array $data): UserEntity
    {
        $userEntity = UserEntity::fromArray($data);

        return $this->userRepositoryInterface->save($userEntity);
    }

    public function login(array $data):UserEntity
    {
        $user = $this->userRepositoryInterface->get($data);
        Log::info('user:'.var_export($user, true));
        return $this->userRepositoryInterface->get($data);
    }
}
