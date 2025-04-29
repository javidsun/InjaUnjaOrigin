<?php

namespace App\Http\Controllers\AuthControllers;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Controllers\Controller;
use App\Domain\Services\Auth\AuthServicesContract;
use App\DTOs\Controller\DTOControllerResponse;
use App\Factories\AuthProviderFactory;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;


class AuthController extends Controller
{
    public function __construct(
        protected ?AuthServicesContract $authServices=null,
        protected ?AuthProviderFactory  $authProviderFactory=null
    )
    {
        $this->authServices ??= app(AuthServicesContract::class);
        $this->authProviderFactory ??= app(AuthProviderFactory::class);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $authStrategy = $this->authProviderFactory->make($request->input(UserJson::PROVIDER, UserJson::TRADITIONAL));
            if (!$request->isValid())
                throw new InvalidArgumentException('Register Request Validation Failed');

            $user = $authStrategy->register($request->all());

            return response()->json([
                UserJson::USER => [
                    UserJson::ID => (string)$user->getId(),
                    UserJson::NAME => $user->getName(),
                    UserJson::EMAIL => $user->getEmail(),
                    UserJson::PROVIDER => $user->getProvider()
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                UserJson::MESSAGE => $e->getMessage()
            ], 422);
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
            Log::info('request sarebbe ' . var_export($request->all(), true));
            $authResponse = $this->authServices->login($request);
            $user = $authResponse->getSingleItem();

            return new DTOControllerResponse(success: true, payload: ['user' => $user, 'token' => $user->createToken('API TOKEN')->plainTextToken], httpStatus: 200, message: 'Login completata');

        } catch (\Throwable $e) {
            return new DTOControllerResponse(success: false, httpStatus: 500, message: $e->getMessage());
        }
    }
}
