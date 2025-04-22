<?php

namespace App\Http\Controllers;

use App\DTOs\Controller\DTOControllerResponse;
use App\Services\IService\AuthServicesContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AuthController
{

    public function __construct(protected AuthServicesContract $authServices)
    {
        $this->authServices ??= app(AuthServicesContract::class);
    }

    public function register(Request $request): DTOControllerResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $authResponse = $this->authServices->register($request);
            $user = $authResponse->getSingleItem();

            return new DTOControllerResponse(
                success: true,
                payload: $user->createToken('API TOKEN')->plainTextToken,
                httpStatus: 200,
                message: 'Registration was successful.'
            );

        } catch (\Exception $e) {
            return new DTOControllerResponse(success: false, httpStatus: 500, message: $e->getMessage());
        }
    }
    //TODO : quando va con successo vorrei che torna a pagina precedente e chiude questa pagina e riempisce textbox
    //TODO : senza riempire confirm password si funziona

    public function login(Request $request): DTOControllerResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return new DTOControllerResponse(success: false, httpStatus: 401, message: 'The information entered is incorrect.');
            }

            $authResponse = $this->authServices->login($request);
            $user = $authResponse->getSingleItem();

            return new DTOControllerResponse(
                success: true,
                payload: ['user' => $user, 'token' => $user->createToken('API TOKEN')->plainTextToken],
                httpStatus: 200,
                message: 'Login successful.'
            );

        } catch (\Exception $e) {
            return new DTOControllerResponse(success: false, httpStatus: 500, message: $e->getMessage());
        }
    }
}
