<?php

namespace App\Http\Requests\Auth;

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'provider'=>'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('REGISTER_REQUEST_VALIDATION_FAILED: Errors: ', $validator->errors()->toArray());

        // Lancia una HttpResponseException per restituire la tua risposta JSON custom
        // ma con status 422 e l'array degli errori.
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'I dati forniti non sono validi.', // Messaggio più descrittivo
            'errors'  => $validator->errors()->toArray() // Array degli errori specifici per campo
        ], 422)); // Usa 422 per errori di validazione    }
    }

}
