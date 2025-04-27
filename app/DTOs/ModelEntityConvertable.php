<?php

namespace App\DTOs;

use App\Domain\Entity;
use App\Entities\UserEntity;

interface ModelEntityConvertable
{
    public function toEntity(): Entity;
    public static function fromEntity(Entity $entity): self;

}
