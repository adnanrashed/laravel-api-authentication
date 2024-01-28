<?php
// app/Http/Controllers/Api/BookingController.php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\Booking::with('participants')->get();
        return response()->json(['bookings' => $bookings]);
    }

    public function create()
    {
        // You can return any specific data or just an empty response
        return response()->json([]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'organizer' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'participants' => 'required|array',
        ]);
        $booking = \App\Models\Booking::create($request->only(['title', 'organizer', 'start_time', 'end_time']));
        // Attach participants to the booking
        $participants = \App\Models\Employee::whereIn('id', $request->input('participants'))->get();
        $booking->participants()->attach($participants);
        return response()->json(['booking' => $booking], 201);
    }
}
