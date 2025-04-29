<?php

namespace App\Domain\Repositories;

use App\Entities\HomeAnnouncementEntity;
use App\Entities\RoleEntity;

interface RoleRepositoryInterface
{
    public function store(RoleEntity $entity):RoleEntity;

}
