<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $booking = Booking::with('attendees')->findOrFail($id);

        // Only decrement if booking was not already confirmed
        if ($booking->status !== 'confirmed') {
            DB::transaction(function () use ($booking) {
                // Decrement ticket quantities based on attendees
                $ticketCounts = $booking->attendees->groupBy('ticket_type_id')->map->count();

                foreach ($ticketCounts as $ticketTypeId => $count) {
                    $ticketType = TicketType::find($ticketTypeId);
                    if ($ticketType) {
                        $ticketType->decrement('quantity', $count);
                        // Ensure quantity doesn't go below 0
                        if ($ticketType->fresh()->quantity < 0) {
                            $ticketType->update(['quantity' => 0]);
                        }
                    }
                }

                $booking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid'
                ]);
            });
        }

        return redirect()->back()->with('success', 'Booking approved successfully! The user can now download their tickets.');
    }

    public function reject($id)
    {
        $booking = Booking::with('attendees')->findOrFail($id);

        // If booking was previously confirmed, restore ticket quantities
        if ($booking->status === 'confirmed') {
            DB::transaction(function () use ($booking) {
                $ticketCounts = $booking->attendees->groupBy('ticket_type_id')->map->count();

                foreach ($ticketCounts as $ticketTypeId => $count) {
                    $ticketType = TicketType::find($ticketTypeId);
                    if ($ticketType) {
                        $ticketType->increment('quantity', $count);
                    }
                }

                $booking->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed'
                ]);
            });
        } else {
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);
        }

        return redirect()->back()->with('error', 'Booking has been rejected.');
    }

    public function show($id)
    {
        $booking = Booking::with(['event', 'user', 'attendees.ticketType'])->findOrFail($id);
        return view('admin.finance.bookings.show', compact('booking'));
    }

    public function destroy($id)
    {
        $booking = Booking::with('attendees')->findOrFail($id);

        // If booking was confirmed, restore ticket quantities before deleting
        if ($booking->status === 'confirmed') {
            DB::transaction(function () use ($booking) {
                $ticketCounts = $booking->attendees->groupBy('ticket_type_id')->map->count();

                foreach ($ticketCounts as $ticketTypeId => $count) {
                    $ticketType = TicketType::find($ticketTypeId);
                    if ($ticketType) {
                        $ticketType->increment('quantity', $count);
                    }
                }

                $booking->delete();
            });
        } else {
            $booking->delete();
        }

        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }
}

