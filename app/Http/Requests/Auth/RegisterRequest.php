<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $array = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'string|min:8',
            'password_confirmation' => 'string|min:8',
        ];
        Log::info('array di name '.var_export($array, true));
        return $array;
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json(['success' => false, 'message' => 'BAD_REQUEST'], 400);
    }

    public function isValid(): bool
    {
        Log::info('array di name '.var_export($this->validated(), true));

        return $this->validated();
    }

}
