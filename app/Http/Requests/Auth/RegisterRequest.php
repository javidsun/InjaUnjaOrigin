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

        ];
        return $array;
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json(['success' => false, 'message' => 'BAD_REQUEST'], 400);
    }

    public function isValid(): bool
    {
        return $this->validated();
    }

}
