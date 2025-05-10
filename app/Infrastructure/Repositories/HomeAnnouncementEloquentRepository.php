<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\AnnouncementRepositoryInterface;
use App\Entities\HomeAnnouncementEntity;
use App\Models\HomeAnnouncement;
use Illuminate\Http\UploadedFile;

class HomeAnnouncementEloquentRepository implements AnnouncementRepositoryInterface
{
    public function saveImage(UploadedFile $image): string
    {
        // TODO JAVID : Salva l'immagine in storage/app/public/announcements e restituisce il percorso
        return $image->store('announcement', 'public');
    }

    public function store(HomeAnnouncementEntity $entity): HomeAnnouncementEntity
    {
        $homeAnnouncement = HomeAnnouncement::fromEntity($entity);
        $homeAnnouncement->save();

        return $homeAnnouncement->toEntity();
    }
}
