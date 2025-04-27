<?php

namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\Auth\RegisterStrategyContract;
use App\Entities\UserEntity;
use ReflectionException;

abstract class AuthService implements RegisterStrategyContract
{
    public function __construct(
        protected ?UserEntity $userEntity = null,
        protected ?UserRepositoryInterface $userRepositoryInterface = null
    )
    {
        $this->userEntity ??= app(UserEntity::class);
        $this->userRepositoryInterface ??= app(UserRepositoryInterface::class);
    }

    /**
     * @throws ReflectionException
     */
    public function register(array $data): UserEntity
    {
        $user = $this->userEntity->fromArray($data);
        return $this->userRepositoryInterface->save($user);
    }
}
