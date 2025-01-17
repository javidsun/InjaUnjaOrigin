<?php

namespace App\Services\IService;

use App\DTOs\Service\DTOServiceResponse;
use App\Models\User;
use Illuminate\Http\Request;

interface AuthServicesContract
{

    public function register(Request $request):DTOServiceResponse;
    public function login(Request $request):DTOServiceResponse;

}
