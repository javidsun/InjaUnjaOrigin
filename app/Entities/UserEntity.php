<?php

namespace App\Entities;

use App\Domain\Entity\Entity;
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
}
