<?php

namespace App\Domain\Services\Auth;

use App\Entities\UserEntity;

interface RegisterStrategyContract
{

    public function register(array $data): string;
    public function login(array $data):string;


}
