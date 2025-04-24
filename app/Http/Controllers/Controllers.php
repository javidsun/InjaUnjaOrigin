<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ad;
use App\Models\Reservation;
use Illuminate\Http\Request;

class Controllers
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getAds()
    {
        $ads = Ad::all();
        return response()->json($ads);
    }

    public function createAd(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image',
        ]);

        $ad = new Ad();
        $ad->title = $validated['title'];
        $ad->description = $validated['description'];
        $ad->category_id = $validated['category_id'];
        if ($request->hasFile('image')) {
            $ad->image = $request->file('image')->store('ads', 'public');
        }
        $ad->save();

        return response()->json($ad, 201);
    }

    public function getUserReservations(Request $request)
    {
        $reservations = Reservation::where('user_id', $request->user()->id)->get();
        return response()->json($reservations);
    }

    public function createReservation(Request $request)
    {
        $validated = $request->validate([
            'ad_id' => 'required|integer',
            'reservation_date' => 'required|date',
        ]);

        $reservation = new Reservation();
        $reservation->user_id = $request->user()->id;
        $reservation->ad_id = $validated['ad_id'];
        $reservation->reservation_date = $validated['reservation_date'];
        $reservation->save();

        return response()->json($reservation, 201);
    }
}
