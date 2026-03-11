<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Booking::with(['event', 'user', 'attendees.ticketType'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(20);
        return view('admin.finance.bookings.index', compact('bookings'));
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);

        return redirect()->back()->with('success', 'Booking approved successfully! The user can now download their tickets.');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'failed'
        ]);

        return redirect()->back()->with('error', 'Booking has been rejected.');
    }

    public function show($id)
    {
        $booking = Booking::with(['event', 'user', 'attendees.ticketType'])->findOrFail($id);
        return view('admin.finance.bookings.show', compact('booking'));
    }
}
