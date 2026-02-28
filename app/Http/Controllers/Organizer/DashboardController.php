<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $organizer_id = Auth::id();

        // Get organizer events
        $events = Event::where('user_id', $organizer_id)->get();
        $eventIds = $events->pluck('id')->toArray();

        // General Stats
        $totalEvents = $events->count();
        
        $totalTickets = \App\Models\BookingAttendee::whereHas('booking', function($query) use ($eventIds) {
            $query->whereIn('event_id', $eventIds)->where('status', 'confirmed');
        })->count();

        $grossRevenue = Booking::whereIn('event_id', $eventIds)->where('status', 'confirmed')->sum('total_amount');
        $commissionAmount = Booking::whereIn('event_id', $eventIds)->where('status', 'confirmed')->sum('commission_amount');
        $netEarnings = $grossRevenue - $commissionAmount;

        // Recent Bookings
        $recentBookings = Booking::with(['event', 'user'])->whereIn('event_id', $eventIds)->where('status', 'confirmed')->latest()->take(5)->get();

        return view('organizer.dashboard', compact('totalEvents', 'totalTickets', 'grossRevenue', 'netEarnings', 'recentBookings', 'events'));
    }
}
