<?php

namespace App\Mapper;

use App\Constant\AnnouncementConst\HomeAnnouncementJson;
use App\Entities\HomeAnnouncementEntity;

class HomeAnnouncementMapper
{

    public function fromArray(array $array): HomeAnnouncementEntity
    {
        return new HomeAnnouncementEntity(
            id: $array[HomeAnnouncementJson::ID] ?? null,
            user_id: $array[HomeAnnouncementJson::USER_ID] ?? auth()->id(),
            title: $array[HomeAnnouncementJson::TITLE] ?? null,
            description: $array[HomeAnnouncementJson::DESCRIPTION] ?? null,
            price: $array[HomeAnnouncementJson::PRICE] ?? null,
            location: $array[HomeAnnouncementJson::LOCATION] ?? null,
            image: $array[HomeAnnouncementJson::IMAGE] ?? null,
            createdAt: $array[HomeAnnouncementJson::CREATED_AT ]?? null,
            updatedAt: $array[HomeAnnouncementJson::UPDATED_AT] ?? null,
        );
    }

}
