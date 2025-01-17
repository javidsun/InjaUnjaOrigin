<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthTokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

$files = glob(__DIR__ . '/instanceWeb/*.php');

foreach ($files as $file) {
    Log::info(basename($file));
    require $file;
}


Route::post('/api/register',function (Request $request) {
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
    }catch (ValidationException $e){
        $errorMessages = implode(' ', array_map(function($error) {
            return implode(' ', $error);
        }, $e->errors()));
        return response(['success' => false, 'message' => $errorMessages], 400);
    }catch(Exception $e) {
        return response(['success' => false,
            'payload' => $e->getMessage()],
            500);
    }
})->middleware(AuthTokenMiddleware::class);//TODO : questo middleware viene utilizzato epr login non per register

Route::middleware('auth.token')->get('/test-middleware', function () {
    return 'Middleware loaded successfully!';
});

Route::post('/api/login', function (Request $request) {
    try {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Errore di validazione',
                'errors' => $validator->errors()
            ],422);

        }
        $loginController = app(AuthController::class);
        $controllerResponse = $loginController->login($request);

        return response(['success' => $controllerResponse->success,
            'payload' => $controllerResponse->payload],
            $controllerResponse->httpStatus);
    }catch (ValidationException $e){
        $errorMessages = implode(' ', array_map(function($error) {
            return implode(' ', $error);
        }, $e->errors()));
        return response(['success' => false, 'message' => $errorMessages], 400);
    }catch (Exception $e) {
        return response(['success' => false,
            'payload' => $e->getMessage()],
            500);
    }
});


