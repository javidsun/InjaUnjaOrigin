<?php

namespace App\Domain;

use App\Domain\Entity\Entity;

interface ModelEntityConvertable
{
    public function toEntity(): Entity;
    public static function fromEntity(Entity $entity): self;

}
