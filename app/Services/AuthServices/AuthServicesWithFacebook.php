<?php

namespace App\Services\AuthServices;

use App\Models\User;
use App\Services\IService\AuthServicesContract;
use Illuminate\Http\Request;

class AuthServicesWithFacebook implements AuthServicesContract
{

    public function register(Request $request): User
    {
        // TODO: Implement register() method.
    }

    public function login(Request $request): User
    {
        // TODO: Implement login() method.
    }
}
