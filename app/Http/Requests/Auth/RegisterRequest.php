<?php

namespace App\Http\Requests\Auth;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            UserJson::NAME => 'required|string|max:255',
            UserJson::EMAIL => 'required|string|email|max:255|unique:users',
            UserJson::PASSWORD => 'required|string|min:8|confirmed',
            UserJson::PROVIDER => 'nullable|string',
            UserJson::ROLES => 'nullable|array',
            UserJson::PERMISSIONS => 'nullable|array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('REGISTER_REQUEST_VALIDATION_FAILED: Errors: ', $validator->errors()->toArray());

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'I dati forniti non sono validi.', // Messaggio più descrittivo
            'errors' => $validator->errors()->toArray(), // Array degli errori specifici per campo
        ], 422)); // Usa 422 per errori di validazione
        // TODO JAVID: creo un documentazione per conoscere tipo di codice di errori JAVID

    }
}
