<?php

namespace App\Http\Controllers;

use App\Services\Announcements\HomeAnnouncementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeAnnouncementController
{
    public function __construct(protected ?HomeAnnouncementService  $homeAnnouncementService = null)
    {
        $this->homeAnnouncementService ??= app(HomeAnnouncementService::class);
    }

    public function store(Request $request):JsonResponse{
        try {
            $validation = $request->validate([
                'title'=> 'required|string|max:255',
                'description'=> 'required|string',
                'price'=>'required|numeric|min:0',
                'location'=>'required|string|max:255',
                'image'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('announcements', 'public');
            } else {
                $imagePath = null;
            }
            return $this->homeAnnouncementService->store($validation);
        }catch (\Throwable $exception){
            return response()->json([$exception->getMessage()],500);
        }
    }
}
