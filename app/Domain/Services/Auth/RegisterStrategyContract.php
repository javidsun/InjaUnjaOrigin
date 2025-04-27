<?php

namespace App\Domain\Services\Auth;

use App\Entities\UserEntity;

interface RegisterStrategyContract
{
    public function register(array $data): UserEntity;

}
