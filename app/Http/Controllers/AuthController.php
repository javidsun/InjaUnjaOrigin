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
    }

    public function register(Request $request): DtoControllerResponse
    {
        try {
            Log::info('arriva a questo punto o no ? ? ??  ?');
            //$this->authServices = $request->attributes->get('authService');

            //$Authtype = $request->input('message', 'Messaggio di test');
            $authResponse = $this->authServices->register($request);
            $user = $authResponse->getSingleItem();

            return new DtoControllerResponse(success: true , payload: $user->createToken('API TOKEN')->plainTextToken,httpStatus: 200,message: 'registrazione completata');
        } catch (\Exception $e) {
            return new DTOControllerResponse(success: false, httpStatus: 500, message: $e->getMessage());
        }
    }
    //TODO : quando va con successo vorrei che torna a pagina precedente e chiude questa pagina e riempisce textbox
    //TODO : senza riempire confirm password si funziona

    public function login(Request $request): DTOControllerResponse
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw new Exception('Auth Attempt to login but invalid credentials');
            }
            Log::info('request sarebbe '.var_export($request->all(),true));
            $authResponse = $this->authServices->login($request);
            $user = $authResponse->getSingleItem();

            return new DTOControllerResponse(success: true,payload: ['user'=>$user , 'token'=>$user->createToken('API TOKEN')->plainTextToken], httpStatus: 200, message: 'Login completata');

        }catch (\Exception $e) {
            return new DTOControllerResponse(success: false, httpStatus: 500, message: $e->getMessage());
        }
    }
}
