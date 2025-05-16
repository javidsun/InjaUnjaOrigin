<?php

namespace App\Entities;

use App\Domain\Entity\Entity;
use Symfony\Component\Uid\Ulid;

class RoleEntity extends Entity
{
    public function __construct(
        public ?Ulid $id,
        public string $name,
        public string $guardName,
    ) {
    }
}
