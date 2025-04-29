<?php

namespace App\Models;

use App\Constant\TableParametersConst\AnnouncementConst\HomeAnnouncementJson;
use App\Domain\Entity;
use App\DTOs\ModelEntityConvertable;
use App\Entities\HomeAnnouncementEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\Uid\Ulid;


/**
 * @property Ulid $id
 * @property Ulid $user_id
 * @property string $title
 * @property string content
 * @property string status
 * @property bool is_pinned
 * @property bool is_pinned_full
 * @property string|null subtitle
 * @property string|null link
 * @property string|null description
 * @property string|null image
 */
class HomeAnnouncement extends Model implements ModelEntityConvertable
{
    protected $fillable = [
        homeAnnouncementJson::USER_ID,
        homeAnnouncementJson::TITLE,
        HomeAnnouncementJson::CONTENT,
        HomeAnnouncementJson::STATUS,
        HomeAnnouncementJson::IS_PINNED,
        HomeAnnouncementJson::IS_PINNED_FULL,
    ];
    protected $hidden = [
        HomeAnnouncementJson::SUBTITLE,
        HomeAnnouncementJson::LINK,
        HomeAnnouncementJson::DESCRIPTION,
        HomeAnnouncementJson::IMAGE,
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
            $this->title,
            $this->content,
            $this->status,
            $this->is_pinned,
            $this->is_pinned_full,
            $this->subtitle,
            $this->link,
            $this->description,
            $this->image
        );
    }

    public static function fromEntity(HomeAnnouncementEntity|Entity $entity): self
    {
        return new self([
            HomeAnnouncementJson::ID => $entity->getId(),
            HomeAnnouncementJson::USER_ID => $entity->getUserId(),
            HomeAnnouncementJson::TITLE => $entity->getTitle(),
            HomeAnnouncementJson::CONTENT => $entity->getContent(),
            HomeAnnouncementJson::STATUS => $entity->getStatus(),
            HomeAnnouncementJson::IS_PINNED => $entity->getIsPinned(),
            HomeAnnouncementJson::IS_PINNED_FULL => $entity->getIsPinnedFull(),
            HomeAnnouncementJson::SUBTITLE => $entity->getSubtitle(),
            HomeAnnouncementJson::LINK => $entity->getLink(),
            HomeAnnouncementJson::DESCRIPTION => $entity->getDescription(),
            HomeAnnouncementJson::IMAGE => $entity->getImage(),
        ]);
    }
}
