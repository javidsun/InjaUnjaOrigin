<?php

namespace App\Http\Requests\Announcement;

use App\Constant\TableParametersConst\AnnouncementConst\HomeAnnouncementJson;
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
        // TODO : da modificare questo per request di creazione
        $array = [
            HomeAnnouncementJson::USER_ID => 'required|ulid',
            HomeAnnouncementJson::LOCATION_ID => 'required|ulid',
            HomeAnnouncementJson::TITLE => 'required|string',
            HomeAnnouncementJson::DESCRIPTION => 'required|string',
            HomeAnnouncementJson::PRICE_PER_NIGHT => 'required|numeric',
            HomeAnnouncementJson::NUM_ROOMS => 'required|numeric',
            HomeAnnouncementJson::NUM_BATHROOMS => 'required|numeric',
            HomeAnnouncementJson::SQUARE_METERS => 'required|numeric',
            HomeAnnouncementJson::MAX_QUESTS => 'required|numeric',
            HomeAnnouncementJson::AMENITIES => 'required|json',
            HomeAnnouncementJson::MAIN_IMAGE_PATH => 'required|string',
            HomeAnnouncementJson::ADDITIONAL_IMAGE_PATHS => 'required|string',
            HomeAnnouncementJson::AVAILABILITY_START_DATE => 'required|date',
            HomeAnnouncementJson::AVAILABILITY_END_DATE => 'required|date',
            HomeAnnouncementJson::IS_ACTIVE => 'required|bool',
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
