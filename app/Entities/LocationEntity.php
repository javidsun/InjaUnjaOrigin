<?php

namespace App\Entities;

use App\Domain\Entity\Entity;
use Symfony\Component\Uid\Ulid;

class LocationEntity extends Entity
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $latitude,
        public readonly string $longitude,
        public readonly string $country
    ) {
    }
}
