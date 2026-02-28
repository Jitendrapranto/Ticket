<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $query = Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // General Stats
        $grossRevenue = (clone $query)->sum('total_amount');
        $totalCommission = (clone $query)->sum('commission_amount');
        $netProfit = (clone $query)->sum('commission_amount'); // For admin, net profit IS the commission
        $organizerPayout = (clone $query)->sum('subtotal_amount');
        
        $totalTickets = \App\Models\BookingAttendee::whereHas('booking', function($q) use ($startDate, $endDate) {
            $q->where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate]);
        })->count();

        $avgOrderValue = $query->count() > 0 ? $grossRevenue / $query->count() : 0;

        // Monthly Trends (for Chart)
        $monthlyTrends = Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('MONTHNAME(created_at) as label'),
                DB::raw('SUM(total_amount) as value')
            )
            ->groupBy('label')
            ->orderBy('created_at', 'asc')
            ->get();

        // Event Breakdown
        $eventStats = Event::with(['category'])
            ->get()
            ->map(function($event) use ($startDate, $endDate) {
                $bookingsQuery = Booking::where('event_id', $event->id)
                    ->where('status', 'confirmed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
                
                $event->tickets_sold = \App\Models\BookingAttendee::whereHas('booking', function($q) use ($event, $startDate, $endDate) {
                    $q->where('event_id', $event->id)->where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate]);
                })->count();
                
                $event->gross_revenue = (clone $bookingsQuery)->sum('total_amount');
                $event->commission = (clone $bookingsQuery)->sum('commission_amount');
                
                return $event;
            });

        return view('admin.reports.sales', compact(
            'totalTickets', 'grossRevenue', 'totalCommission', 'netProfit', 'organizerPayout',
            'avgOrderValue', 'monthlyTrends', 'eventStats', 'startDate', 'endDate'
        ));
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $bookings = Booking::with(['event', 'event.organizer'])
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "platform_sales_" . now()->format('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Fetch Event Summary Data
        $eventStats = Event::with(['category', 'organizer'])
            ->get()
            ->map(function($event) use ($startDate, $endDate) {
                $bookingsQuery = Booking::where('event_id', $event->id)
                    ->where('status', 'confirmed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
                
                $event->tickets_sold = \App\Models\BookingAttendee::whereHas('booking', function($q) use ($event, $startDate, $endDate) {
                    $q->where('event_id', $event->id)->where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate]);
                })->count();
                
                $event->gross_revenue = (clone $bookingsQuery)->sum('total_amount');
                $event->commission = (clone $bookingsQuery)->sum('commission_amount');
                
                return $event;
            });

        $bookings = Booking::with(['event', 'event.organizer', 'attendees'])
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $callback = function() use($eventStats, $bookings) {
            $file = fopen('php://output', 'w');
            
            // Section 1: Platform Wide Event Summary
            fputcsv($file, ['--- PLATFORM EVENT PERFORMANCE SUMMARY ---']);
            fputcsv($file, ['Event Name', 'Organizer', 'Category', 'Tickets Sold', 'Gross Revenue', 'Platform Commission']);
            foreach ($eventStats as $event) {
                fputcsv($file, [
                    $event->title,
                    $event->organizer->name ?? 'N/A',
                    $event->category->name ?? 'N/A',
                    $event->tickets_sold,
                    '৳' . number_format($event->gross_revenue, 2),
                    '৳' . number_format($event->commission, 2)
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, []);

            // Section 2: Detailed Transactions
            fputcsv($file, ['--- ALL PLATFORM TRANSACTIONS ---']);
            fputcsv($file, ['Date', 'Booking ID', 'Event Name', 'Organizer', 'Tickets', 'Gross Amount', 'Commission', 'Org Payout']);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d H:i'),
                    $booking->booking_id,
                    $booking->event->title ?? 'N/A',
                    $booking->event->organizer->name ?? 'N/A',
                    $booking->attendees->count(),
                    '৳' . number_format($booking->total_amount, 2),
                    '৳' . number_format($booking->commission_amount, 2),
                    '৳' . number_format($booking->subtotal_amount, 2)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
