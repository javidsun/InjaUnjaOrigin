<?php

namespace App\Http\Requests\Role;

use App\Constant\TableParametersConst\RoleJson;
use Illuminate\Foundation\Http\FormRequest;

class RolePostRequest extends FormRequest
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
            RoleJson::NAME => 'required|string|max:255',
            RoleJson::DESCRIPTION => 'required|string|max:255',
        ];
    }
}
