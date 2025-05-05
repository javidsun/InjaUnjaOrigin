<?php

namespace App\Entities;

use App\Domain\Entity;
use Symfony\Component\Uid\Ulid;

class UserEntity extends Entity
{
    public function __construct(
        protected ?Ulid $id,
        protected string $name,
        protected string $email,
        protected ?string $password,
        protected ?string $provider,
        protected ?string $providerId
    ) {
    }

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function getProviderId(): ?string
    {
        return $this->providerId;
    }
}
