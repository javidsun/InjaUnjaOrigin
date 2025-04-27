<?php

namespace App\Services\Announcements;

use App\Constant\AnnouncementConst\HomeAnnouncementJson;
use App\Domain\Services\Announcement\AnnouncementContract;
use App\Infrastructure\Repositories\HomeAnnouncementRepository;
use App\Mapper\HomeAnnouncementMapper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class HomeAnnouncementService implements AnnouncementContract
{
    public function __construct(
        protected ?HomeAnnouncementRepository $homeAnnouncementRepository = null,
        protected ?HomeAnnouncementMapper     $homeAnnouncementMapper = null
    )
    {
        $this->homeAnnouncementRepository ??=app(HomeAnnouncementRepository::class);
        $this->homeAnnouncementMapper ??=app(HomeAnnouncementMapper::class);
    }

    /**
     * @throws \Exception
     */
    public function store(array $validation): JsonResponse
    {
        if(Auth::check())
            return response()->json(['error' => 'Utente non autenticato'], 401);

        $imagePath = $this->homeAnnouncementRepository->saveImage($validation[HomeAnnouncementJson::IMAGE]);
        $validation[HomeAnnouncementJson::IMAGE] = $imagePath;
        $homeAnnouncement = $this->homeAnnouncementMapper->fromArray($validation);
        $this->homeAnnouncementRepository->store($homeAnnouncement);
        return response()->json(['message' => 'Annuncio creato con successo!'], 201);
    }
}
