<?php

namespace App\Models;

use App\Constant\TableParametersConst\AnnouncementConst\HomeAnnouncementJson;
use App\Domain\Entity\Entity;
use App\Domain\Model\Model;
use App\Entities\HomeAnnouncementEntity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Mix;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Uid\Ulid;

/**
 * @property Ulid $id
 * @property Ulid $user_id
 * @property Ulid $location_id
 * @property string $title
 * @property string $description
 * @property float $price_per_night
 * @property int $num_rooms
 * @property int $num_bathrooms
 * @property int $square_meters
 * @property int $max_quests
 * @property mix $amenities
 * @property string $main_image_path
 * @property mix $additional_image_paths
 * @property date $availability_start_date
 * @property date $availability_end_date
 * @property bool $is_active
 */
class HomeAnnouncement extends Model
{
    public $incrementing = false;

    protected $fillable = [
        HomeAnnouncementJson::ID,
        HomeAnnouncementJson::USER_ID,
        HomeAnnouncementJson::LOCATION_ID,
        HomeAnnouncementJson::TITLE,
        HomeAnnouncementJson::DESCRIPTION,
        HomeAnnouncementJson::PRICE_PER_NIGHT,
        HomeAnnouncementJson::NUM_ROOMS,
        HomeAnnouncementJson::NUM_BATHROOMS,
        HomeAnnouncementJson::SQUARE_METERS,
        HomeAnnouncementJson::MAX_QUESTS,
        HomeAnnouncementJson::AMENITIES,
        HomeAnnouncementJson::MAIN_IMAGE_PATH,
        HomeAnnouncementJson::ADDITIONAL_IMAGE_PATHS,
        HomeAnnouncementJson::AVAILABILITY_START_DATE,
        HomeAnnouncementJson::AVAILABILITY_END_DATE,
        HomeAnnouncementJson::IS_ACTIVE,
    ];

    protected $hidden = [

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toEntity(): HomeAnnouncementEntity
    {
        return new HomeAnnouncementEntity(
            $this->id,
            $this->user_id,
            $this->location_id,
            $this->title,
            $this->description,
            $this->price_per_night,
            $this->num_rooms,
            $this->num_bathrooms,
            $this->square_meters,
            $this->max_quests,
            $this->amenities,
            $this->main_image_path,
            $this->additional_image_paths,
            $this->availability_start_date,
            $this->availability_end_date,
            $this->is_active,
        );
    }

    public static function fromEntity(HomeAnnouncementEntity|Entity $entity): self
    {
        return new self([
            HomeAnnouncementJson::USER_ID => $entity->id,
            HomeAnnouncementJson::LOCATION_ID => $entity->location_id,
            HomeAnnouncementJson::TITLE => $entity->title,
            HomeAnnouncementJson::DESCRIPTION => $entity->description,
            HomeAnnouncementJson::PRICE_PER_NIGHT => $entity->price_per_night,
            HomeAnnouncementJson::NUM_ROOMS => $entity->num_rooms,
            HomeAnnouncementJson::NUM_BATHROOMS => $entity->num_bathrooms,
            HomeAnnouncementJson::SQUARE_METERS => $entity->square_meters,
            HomeAnnouncementJson::MAX_QUESTS => $entity->max_quests,
            HomeAnnouncementJson::AMENITIES => $entity->amenities,
            HomeAnnouncementJson::MAIN_IMAGE_PATH => $entity->main_image_path,
            HomeAnnouncementJson::ADDITIONAL_IMAGE_PATHS => $entity->additional_image_path,
            HomeAnnouncementJson::AVAILABILITY_START_DATE => $entity->availability_start_date,
            HomeAnnouncementJson::AVAILABILITY_END_DATE => $entity->availability_end_date,
            HomeAnnouncementJson::IS_ACTIVE => $entity->is_active,
        ]);
    }

    public function homeAnnouncements(): HasOne
    {
        return $this->hasOne(Location::class);

    }
}
