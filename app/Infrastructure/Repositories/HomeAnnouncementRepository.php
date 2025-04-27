<?php

namespace App\Infrastructure\Repositories;


use App\Entities\HomeAnnouncementEntity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class HomeAnnouncementRepository
{
    public function saveImage(UploadedFile $image):string
    {
        // Salva l'immagine in storage/app/public/announcements e restituisce il percorso
        return $image->store('announcement','public');
    }
    public function Store(HomeAnnouncementEntity $homeAnnouncementEntity):void
    {
        DB::table('announcements')->insert([
            'user_id' => $homeAnnouncementEntity->getUserId(),
            'title' => $homeAnnouncementEntity->getTitle(),
            'description' => $homeAnnouncementEntity->getDescription(),
            'price' => $homeAnnouncementEntity->getPrice(),
            'location' => $homeAnnouncementEntity->getLocation(),
            'image' => $homeAnnouncementEntity->getImage(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

}
