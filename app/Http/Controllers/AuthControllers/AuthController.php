<?php

namespace App\Http\Controllers\AuthControllers;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Controllers\Controller;
use App\DTOs\Controller\DTOControllerResponse;
use App\Factories\AuthProviderFactory;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        protected ?AuthProviderFactory $authProviderFactory = null
    ) {
        $this->authProviderFactory ??= app(AuthProviderFactory::class);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            Log::info('request sarebbe '.var_export($request->all(), true));
            $validatedData = $request->validated();

            $authStrategy = $this->authProviderFactory->make($request->input(UserJson::PROVIDER, UserJson::TRADITIONAL));

            $registrationPayload = $validatedData;
            if (! isset($registrationPayload[UserJson::PROVIDER])) {
                $registrationPayload[UserJson::PROVIDER] = $request->input(UserJson::PROVIDER, UserJson::TRADITIONAL);
            }
            if (! isset($registrationPayload[UserJson::PROVIDER_ID])) {
                $registrationPayload[UserJson::PROVIDER_ID] = null;
            }

            $user = $authStrategy->register($registrationPayload);

            return response()->json([
                UserJson::USER => [
                    UserJson::ID => (string) $user->getId(),
                    UserJson::NAME => $user->getName(),
                    UserJson::EMAIL => $user->getEmail(),
                    UserJson::PROVIDER => $user->getProvider(),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('AUTH_CONTROLLER_REGISTER: Throwable: '.$e->getMessage(), [
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                UserJson::MESSAGE => 'Si è verificato un errore durante la registrazione. Riprova più tardi.',
            ], 500);
        }
    }
    // TODO : quando va con successo vorrei che torna a pagina precedente e chiude questa pagina e riempisce textbox
    // TODO : senza riempire confirm password si funziona

    public function login(Request $request): DTOControllerResponse
    {
        try {
            if (! Auth::attempt($request->only('email', 'password'))) {
                throw new Exception('Auth Attempt to login but invalid credentials');
            }
            Log::info('request sarebbe '.var_export($request->all(), true));
            $authResponse = $this->authServices->login($request);
            $user = $authResponse->getSingleItem();

            return new DTOControllerResponse(success: true, payload: ['user' => $user, 'token' => $user->createToken('API TOKEN')->plainTextToken], httpStatus: 200, message: 'Login completata');

        } catch (\Throwable $e) {
            return new DTOControllerResponse(success: false, httpStatus: 500, message: $e->getMessage());
        }
    }
}
