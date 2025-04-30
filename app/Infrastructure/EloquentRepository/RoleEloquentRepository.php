<?php

namespace App\Infrastructure\EloquentRepository;

use App\Domain\Repositories\RoleRepositoryInterface;
use App\Entities\RoleEntity;
use App\Models\Role;

class RoleEloquentRepository implements RoleRepositoryInterface
{
    public function store(RoleEntity $entity): RoleEntity
    {
        $model = Role::fromEntity($entity);
        $model->save();

        return $model->toEntity();
    }
}
