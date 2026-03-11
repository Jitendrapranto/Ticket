<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingAttendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Sales & Today's Sales
        $totalSales = Booking::where('status', 'confirmed')->sum('total_amount');
        $todaySales = Booking::where('status', 'confirmed')->whereDate('created_at', now())->sum('total_amount');

        // Total Events & Today's Events
        $totalEvents = Event::count();
        $todayEvents = Event::whereDate('date', now())->count();

        // Total Organizers & Organizer Requests
        $totalOrganizers = User::where('role', 'organizer')->count();
        $organizerRequests = User::where('role', 'pending_organizer')->count();

        // Event Approval Requests
        $eventApprovalRequests = Event::where('is_approved', false)->count();

        // Payment Approval Requests (assuming pending bookings)
        $paymentApprovalRequests = Booking::where('status', 'pending')->count();

        // Total Customers & Total Bookings
        $totalCustomers = User::where('role', 'user')->count();
        $totalBookings = Booking::count();

        // Extra context for compatibility
        $totalGrossSales = $totalSales;
        $publishedEvents = Event::where('status', 'Live')->count();

        // Recent Transactions
        $recentTransactions = Booking::with(['event', 'user'])
            ->latest()
            ->limit(8)
            ->get();

        // Top Events based on booking count
        $topEvents = Event::withCount(['bookings' => function($q) {
            $q->where('status', 'confirmed');
        }])
        ->orderBy('bookings_count', 'desc')
        ->limit(4)
        ->get();

        return view('admin.index', compact(
            'totalSales', 'todaySales', 'totalEvents', 'todayEvents',
            'totalOrganizers', 'organizerRequests', 'eventApprovalRequests', 'paymentApprovalRequests',
            'totalCustomers', 'totalBookings', 'totalGrossSales', 'publishedEvents',
            'recentTransactions', 'topEvents'
        ));
    }
}
