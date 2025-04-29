<?php

namespace App\Domain\Services;

interface RoleServiceContract
{
    public function create(array $data): void;
}
