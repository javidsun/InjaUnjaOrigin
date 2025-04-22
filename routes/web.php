<?php

use App\Constant\AuthConst\SocialiteDeriveConst;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuthController;
use App\Http\Middleware\AuthTokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;


$files = glob(__DIR__ . '/instanceWeb/*.php');

foreach ($files as $file) {
    Log::info(basename($file));
    require $file;
}



Route::post('/api/register', function (Request $request) {
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errore di validazione',
                'errors' => $validator->errors()
            ], 422);
        }
        $authController = app(AuthController::class);
        $authControllerResponse = $authController->register($request);

        return response(['success' => $authControllerResponse->success,
            'payload' => $authControllerResponse->payload],
            $authControllerResponse->httpStatus);
    } catch (ValidationException $e) {
        $errorMessages = implode(' ', array_map(function ($error) {
            return implode(' ', $error);
        }, $e->errors()));
        return response(['success' => false, 'message' => $errorMessages], 400);
    } catch (Exception $e) {
        return response(['success' => false,
            'payload' => $e->getMessage()],
            500);
    }
})->middleware(AuthTokenMiddleware::class);//TODO : questo middleware viene utilizzato epr login non per register

Route::middleware('auth.token')->get('/test-middleware', function () {
    return 'Middleware loaded successfully!';
});

Route::post('/api/login2', function (Request $request) {
    try {
        /**
         * URL: http://127.0.0.1:8000/api/login
         * request : {
         * "email": "tuo@email.com",
         * "password": "tua_password"
         * }
         *
         * response  : {
         * "message": "Login effettuato con successo",
         * "user": {
         * "id": 1,
         * "email": "tuo@email.com"
         * },
         * "token": "1|h5aGhDfGhjj987..."
         * }
         */
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errore di validazione',
                'errors' => $validator->errors()
            ], 422);

        }
        $loginController = app(AuthController::class);
        $controllerResponse = $loginController->login($request);

        return response(['success' => $controllerResponse->success,
            'payload' => $controllerResponse->payload],
            $controllerResponse->httpStatus);
    } catch (ValidationException $e) {
        $errorMessages = implode(' ', array_map(function ($error) {
            return implode(' ', $error);
        }, $e->errors()));
        return response(['success' => false, 'message' => $errorMessages], 400);
    } catch (Exception $e) {
        return response(['success' => false,
            'payload' => $e->getMessage()],
            500);
    }
});
Route::post('/api/login2', function (Request $request) {
    try {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errore di validazione',
                'errors' => $validator->errors()
            ], 422);
        }

        $authController = app(AuthController::class);
        $controllerResponse = $authController->login($request);

        return response()->json([
            'success' => $controllerResponse->success,
            'payload' => $controllerResponse->payload,
        ], $controllerResponse->httpStatus);

    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => implode(' ', array_map(fn($error) => implode(' ', $error), $e->errors()))
        ], 400);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
});

/*Route::post('/api/login', [AuthController::class, 'login']);*/


Route::middleware('auth:sanctum')->post('/api/logout', function (Request $request) {
    try {
        /**
         *URL: http://127.0.0.1:8000/api/logout
         *
         * {
         * response:"message": "Logout effettuato con successo"
         * }
         */
        $authController = app(AuthController::class);
        return $authController->logout($request);
    } catch (ValidationException $error) {
        $errorMessages = implode(' ', array_map(function ($error) {
            return implode(' ', $error);
        }, $error->errors()));
        return response(['success' => false, 'message' => $errorMessages], 400);
    } catch (Exception $e) {
        return response(['success' => false, 'message' => $e->getMessage()], 500);
    }
});

Route::middleware('auth:sanctum')->get('api/user', function (Request $request) {
    /**
     * per proteggere user in tutto il progetto poi vediamo come
     * Authorization: Bearer <il_tuo_token>
     * Content-Type: application/json
     * esempio :
     * curl -X POST http://127.0.0.1:8000/api/logout \
     * -H "Authorization: Bearer <il_tuo_token>" \
     * -H "Content-Type: application/json"
     *
     *Cosa fa l'Autorizzazione "Bearer Token"?
     * L'intestazione Authorization: Bearer <il_tuo_token> indica che:
     *
     * L’utente sta inviando un token di accesso generato al momento del login.
     * Laravel verifica se il token è valido prima di eseguire l'azione richiesta.
     * Il prefisso Bearer dice a Laravel che il token è un JWT (JSON Web Token) o un token API.
     */
    return $request->user();
});

Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);

// Callback dopo il login con il provider
Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);


