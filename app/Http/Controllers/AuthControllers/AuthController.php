<?php

namespace App\Http\Controllers\AuthControllers;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use App\Domain\Controllers\Controller;
use App\Factories\AuthProviderFactory;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\LoginRequest;
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

    public function login(LoginRequest $request): JsonResponse
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

            $user = $authStrategy->login($registrationPayload);

            return response()->json([
                UserJson::USER => [
                    UserJson::NAME => $user->getName(),
                    UserJson::EMAIL => $user->getEmail(),
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
                UserJson::MESSAGE => 'Si è verificato un errore durante la login. Riprova più tardi.',
            ], 500);
        }
    }
}
