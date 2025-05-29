<?php

namespace App\Http\Controllers\AuthControllers;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Controllers\Controller;
use App\Factories\AuthProviderFactory;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\JsonResponse;
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
            $validatedData = $request->validated();

            $authStrategy = $this->authProviderFactory->make($request->input(UserJson::PROVIDER, UserJson::TRADITIONAL));

            $registrationPayload = $validatedData;
            if (! isset($registrationPayload[UserJson::PROVIDER])) {
                $registrationPayload[UserJson::PROVIDER] = $request->input(UserJson::PROVIDER, UserJson::TRADITIONAL);
            }
            if (! isset($registrationPayload[UserJson::PROVIDER_ID])) {
                $registrationPayload[UserJson::PROVIDER_ID] = null;
            }

            return response()->json([
                'access_token' => $authStrategy->register($registrationPayload),
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $e) {
            Log::error('AUTH_CONTROLLER_LOGIN: Throwable: '.$e->getMessage(), [
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            $statusCode = 500;
            $message = 'Si è verificato un errore durante il login. Riprova più tardi.';

            if ($e->getMessage() === 'Credenziali non valide.') {
                $statusCode = 401;
                $message = 'Credenziali non valide.';
            }

            return response()->json([
                'success' => false,
                UserJson::MESSAGE => $message,
            ], $statusCode);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {

            $validatedData = $request->validated();
            $authStrategy = $this->authProviderFactory->make($request->input(UserJson::PROVIDER, UserJson::TRADITIONAL));

            $registrationPayload = $validatedData;
            if (! isset($registrationPayload[UserJson::PROVIDER])) {
                $registrationPayload[UserJson::PROVIDER] = $request->input(UserJson::PROVIDER, UserJson::TRADITIONAL);
            }
            if (! isset($registrationPayload[UserJson::PROVIDER_ID])) {
                $registrationPayload[UserJson::PROVIDER_ID] = null;
            }

            return response()->json([
                'access_token' => $authStrategy->login($registrationPayload),
                'token_type' => 'Bearer',
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
                UserJson::MESSAGE => 'Si è verificato un errore durante la login. Riprova più tardi.',
            ], 500);
        }
    }
}
