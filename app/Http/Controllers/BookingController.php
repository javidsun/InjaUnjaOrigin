<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controllers
{
    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();
        return response()->json($booking);
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();
        return response()->json($booking);
    }
}
