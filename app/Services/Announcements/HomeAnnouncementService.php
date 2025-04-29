<?php

namespace App\Services\Announcements;

use App\Constant\AnnouncementConst\HomeAnnouncementJson;
use App\Domain\Services\Announcement\AnnouncementContract;
use App\Entities\HomeAnnouncementEntity;
use App\Infrastructure\Repositories\HomeAnnouncementEloquentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class HomeAnnouncementService implements AnnouncementContract
{
    public function __construct(
        protected ?HomeAnnouncementEloquentRepository $homeAnnouncementRepository = null,
        protected ?HomeAnnouncementEntity $homeAnnouncementEntity = null,
    )
    {
        $this->homeAnnouncementRepository ??=app(HomeAnnouncementEloquentRepository::class);
        $this->homeAnnouncementEntity ??=app(HomeAnnouncementEntity::class);
    }

    /**
     * @throws \Exception
     */
    public function store(array $dataParameters): JsonResponse
    {
        if(!Auth::check()) //TODO : controllare questo cosa fa
            return response()->json(['error' => 'Utente non autenticato'], 401);

        $imagePath = $this->homeAnnouncementRepository->saveImage($dataParameters[HomeAnnouncementJson::IMAGE]);
        $dataParameters[HomeAnnouncementJson::IMAGE] = $imagePath;
        $homeAnnouncement = $this->homeAnnouncementEntity->fromArray($dataParameters);
        $this->homeAnnouncementRepository->store($homeAnnouncement);
        return response()->json(['message' => 'Annuncio creato con successo!'], 201);
    }
}
