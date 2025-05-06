<?php

namespace App\Domain\Services;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\Auth\RegisterStrategyContract;
use App\Entities\UserEntity;
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

}
