<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use App\Models\BookingAttendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScannerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $organizerId = $user->organizer_id;

        $today = Carbon::today();

        // 1. Total live events today (happening today)
        $totalEventsToday = Event::where('user_id', $organizerId)
            ->where('status', 'Live')
            ->whereDate('date', $today)
            ->count();

        // 2. Total purchased tickets for live events today
        $attendeesQuery = BookingAttendee::whereHas('booking', function($q) use ($organizerId, $today) {
            $q->whereHas('event', function($eq) use ($organizerId, $today) {
                $eq->where('user_id', $organizerId)
                   ->where('status', 'Live')
                   ->whereDate('date', $today);
            })->where('payment_status', 'paid');
        });

        $totalPurchasedToday = (clone $attendeesQuery)->count();

        // 3. Scanned tickets for events today
        $scannedToday = (clone $attendeesQuery)->where('is_scanned', true)->count();

        // 4. Pending tickets for events today
        $pendingToday = (clone $attendeesQuery)->where('is_scanned', false)->count();

        // 5. Total sales for events today
        $totalSalesToday = $attendeesQuery->with('ticketType')->get()->sum(function($attendee) {
            return $attendee->ticketType->price ?? 0;
        });

        return view('scanner.dashboard', compact(
            'totalEventsToday',
            'totalPurchasedToday',
            'scannedToday',
            'pendingToday',
            'totalSalesToday'
        ));
    }

    public function showScan()
    {
        return view('scanner.scan');
    }

    public function processScan(Request $request)
    {
        $ticket_number = $request->ticket_number;
        $attendee = BookingAttendee::with(['booking.event', 'ticketType', 'booking.user'])
            ->where('ticket_number', $ticket_number)
            ->first();

        if (!$attendee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid ticket number.'
            ]);
        }

        // Verify if the event belongs to the scanner's organizer and is live
        if ($attendee->booking->event->user_id !== Auth::user()->organizer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. This ticket belongs to another organizer.'
            ]);
        }

        if ($attendee->booking->event->status !== 'Live') {
             return response()->json([
                'status' => 'error',
                'message' => 'The associated event is currently ' . $attendee->booking->event->status . ' (not scan-able).'
            ]);
        }

        if ($attendee->is_scanned) {
            return response()->json([
                'status' => 'already_scanned',
                'message' => 'Ticket already scanned at ' . $attendee->scanned_at->format('M d, Y h:i A'),
                'attendee' => $attendee
            ]);
        }

        if ($attendee->booking->payment_status !== 'paid') {
             return response()->json([
                'status' => 'invalid',
                'message' => 'Ticket is invalid: Payment is ' . $attendee->booking->payment_status,
                'attendee' => $attendee
            ]);
        }

        // Success - mark as scanned
        $attendee->update([
            'is_scanned' => true,
            'scanned_at' => now(),
            'scanner_id' => Auth::id()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in successful!',
            'attendee' => $attendee->load(['booking.event', 'ticketType'])
        ]);
    }

    public function showManualCheckin()
    {
        return view('scanner.manual-checkin');
    }
}
