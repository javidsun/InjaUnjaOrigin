<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controllers
{
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

    public function deleteAd($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->delete();
        return response()->json(['message' => 'Ad deleted successfully']);
    }
}
