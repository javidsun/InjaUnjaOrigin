<?php

namespace App\Http\Requests\Announcement;

use App\Constant\AnnouncementConst\HomeAnnouncementJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class HomeAnnouncementPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $array = [
            HomeAnnouncementJson::USER_ID=> 'required|string',
            HomeAnnouncementJson::TITLE=> 'required|string',
            HomeAnnouncementJson::CONTENT=> 'required|string',
            HomeAnnouncementJson::STATUS=> 'required|string',
            HomeAnnouncementJson::IS_PINNED=> 'required|boolean',
            HomeAnnouncementJson::IS_PINNED_FULL=> 'required|boolean',
            HomeAnnouncementJson::SUBTITLE=> 'nullable|string',
            HomeAnnouncementJson::LINK=> 'nullable|string',
            HomeAnnouncementJson::DESCRIPTION=> 'nullable|string',
            HomeAnnouncementJson::IMAGE=> 'nullable|string',
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
