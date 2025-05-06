<?php

namespace App\Entities;

use App\Domain\Entity;
use Symfony\Component\Uid\Ulid;

class UserEntity extends Entity
{
    public function __construct(
        public readonly ?Ulid $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password, // Password in chiaro in questa entità
        public readonly ?string $provider,
        public readonly ?string $providerId
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
