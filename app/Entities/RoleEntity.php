<?php

namespace App\Entities;

use App\Domain\Entity;
use Symfony\Component\Uid\Ulid;

class RoleEntity extends Entity
{
    public function __construct(
        protected ?Ulid   $id,
        protected string  $name,
        protected ?string $description = null,
    )
    {
    }

    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

}
