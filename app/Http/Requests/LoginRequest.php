<?php

namespace App\Http\Requests;

use App\Constant\TableParametersConst\AuthConst\UserJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            UserJson::EMAIL => 'nullable|string|email|max:255',
            UserJson::PASSWORD => 'nullable|string|min:8',
            UserJson::PROVIDER => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::warning('LOGIN_REQUEST_VALIDATION_FAILED: Errors: ', $validator->errors()->toArray());

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'I dati forniti non sono validi.', // Messaggio più descrittivo
            'errors' => $validator->errors()->toArray(), // Array degli errori specifici per campo
        ], 422)); // Usa 422 per errori di validazione
        // TODO JAVID : creazione di documentazione
    }
}
