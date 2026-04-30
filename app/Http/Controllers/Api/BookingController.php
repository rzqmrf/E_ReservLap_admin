<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(
            Booking::with(['user', 'field', 'payment'])->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'field_id'       => 'required|exists:fields,id',
            'date'           => 'required|date',
            'start_time'     => 'required',
            'end_time'       => 'required',
            'duration_hours' => 'required|integer|min:1',
            'total_price'    => 'required|integer|min:0',
        ]);

        $booking = Booking::create([
            'booking_code'   => 'BK' . strtoupper(Str::random(8)),
            'user_id'        => $request->user_id,
            'field_id'       => $request->field_id,
            'date'           => $request->date,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
            'duration_hours' => $request->duration_hours,
            'total_price'    => $request->total_price,
            'status'         => 'pending',
        ]);

        return response()->json($booking->load(['user', 'field']), 201);
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'field', 'payment'])->findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return response()->json($booking);
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return response()->json(['message' => 'Booking berhasil dihapus']);
    }

    // Approve booking
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'approved']);
        return response()->json(['message' => 'Booking disetujui', 'booking' => $booking]);
    }

    // Reject booking
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'rejected']);
        return response()->json(['message' => 'Booking ditolak', 'booking' => $booking]);
    }

    // Booking by user
    public function byUser($userId)
    {
        $bookings = Booking::with(['field', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
        return response()->json($bookings);
    }
}
