<?php

namespace App\Domain\Services;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\Auth\RegisterStrategyContract;
use App\Entities\UserEntity;
use ReflectionException;

abstract class AuthService implements RegisterStrategyContract
{
    public function __construct(
       // protected ?UserEntity $userEntity = null,
        protected ?UserRepositoryInterface $userRepositoryInterface = null
    ) {
        //$this->userEntity ??= app(UserEntity::class);
        $this->userRepositoryInterface ??= app(UserRepositoryInterface::class);
    }

    /**
     * @throws ReflectionException
     */
    public function register2(array $data): UserEntity
    {
        //$user = $this->userEntity->fromArray($data);

        //return $this->userRepositoryInterface->save($user);
    }
    public function register(array $data): UserEntity
    {
        // $data qui è $validatedData dal controller, che include name, email, password, password_confirmation
        // e anche UserJson::PROVIDER e UserJson::PROVIDER_ID (che potrebbe essere null)
        // L'UserEntity non ha password_confirmation

        $userEntity = new UserEntity(
            id: null, // L'ID sarà generato (dal DB o dal repository/model)
            name: $data['name'],
            email: $data['email'],
            password: $data['password'], // La password non è ancora hashata qui se viene direttamente da $validatedData
            // L'hashing dovrebbe avvenire nel Model (fromEntity) o nel Repository prima di salvare
            provider: $data[UserJson::PROVIDER] ?? UserJson::TRADITIONAL,
            providerId: $data[UserJson::PROVIDER_ID] ?? null
        );

        // Il repository si occuperà dell'hashing della password e del salvataggio
        return $this->userRepositoryInterface->save($userEntity);
    }

}
