<?php

namespace App\Http\Controllers\AnnouncementControllers;

use App\Domain\Controllers\Controller;
use App\Http\Requests\Announcement\HomeAnnouncementPostRequest;
use App\Services\Announcements\HomeAnnouncementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class HomeAnnouncementController extends Controller
{
    public function __construct(protected ?HomeAnnouncementService  $homeAnnouncementService = null)
    {
        $this->homeAnnouncementService ??= app(HomeAnnouncementService::class);
    }

    public function store(HomeAnnouncementPostRequest $request):JsonResponse{
        try {
            if (!$request->isValid())
                throw new InvalidArgumentException('home announcement Request Validation Failed');
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('announcements', 'public');
            } else {
                $imagePath = null;
            }
            return $this->homeAnnouncementService->store($request->all());
        }catch (\Throwable $exception){
            return response()->json([$exception->getMessage()],500);
        }
    }
}
