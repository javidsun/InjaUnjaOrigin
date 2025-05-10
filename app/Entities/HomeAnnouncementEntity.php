<?php

namespace App\Entities;

use App\Domain\Entity\Entity;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Uid\Ulid;

class HomeAnnouncementEntity extends Entity
{
    public function __construct(
        public readonly Ulid $id,
        public readonly Ulid $user_id,
        public readonly Ulid $location_id,
        public readonly string $title,
        public readonly string $description,
        public readonly float $price_per_night,
        public readonly int $num_rooms,
        public readonly int $num_bathrooms,
        public readonly int $square_meters,
        public readonly int $max_quests,
        public readonly mixed $amenities,
        public readonly string $main_image_path,
        public readonly mixed $additional_image_path,
        public readonly Date $availability_start_date,
        public readonly Date $availability_end_date,
        public readonly bool $is_active,
    ) {
    }

}
