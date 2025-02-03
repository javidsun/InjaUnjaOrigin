<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controllers
{
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
