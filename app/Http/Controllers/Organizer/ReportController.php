<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $organizer_id = Auth::id();
        $eventIds = Event::where('user_id', $organizer_id)->pluck('id')->toArray();

        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        if (empty($eventIds)) {
            $netEarnings = 0;
            $totalCommission = 0;
            $grossRevenue = 0;
            $totalTickets = 0;
            $avgOrderValue = 0;
            $monthlyTrends = collect([]);
            $eventStats = collect([]);
            
            return view('organizer.reports.sales', compact(
                'netEarnings', 'totalCommission', 'grossRevenue', 
                'totalTickets', 'avgOrderValue', 'monthlyTrends', 
                'eventStats', 'startDate', 'endDate'
            ));
        }

        $query = Booking::whereIn('event_id', $eventIds)
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        // General Stats
        $grossRevenue = (clone $query)->sum('total_amount'); // Total collected from customers
        $totalCommission = (clone $query)->sum('commission_amount');
        $netEarnings = (clone $query)->sum('subtotal_amount'); // What the organizer actually gets
        
        $totalTickets = \App\Models\BookingAttendee::whereHas('booking', function($q) use ($startDate, $endDate, $eventIds) {
            $q->whereIn('event_id', $eventIds)->where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate]);
        })->count();

        $avgOrderValue = $query->count() > 0 ? $grossRevenue / $query->count() : 0;

        // Monthly Trends (for Chart)
        $monthlyTrends = Booking::whereIn('event_id', $eventIds)
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('MONTHNAME(created_at) as label'),
                DB::raw('SUM(total_amount) as value') 
            )
            ->groupBy('label')
            ->orderBy('created_at', 'asc')
            ->get();

        // Event Breakdown
        $eventStats = Event::where('user_id', $organizer_id)
            ->with(['category'])
            ->get()
            ->map(function($event) use ($startDate, $endDate) {
                $bookingsQuery = Booking::where('event_id', $event->id)
                    ->where('status', 'confirmed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
                
                $event->tickets_sold = \App\Models\BookingAttendee::whereHas('booking', function($q) use ($event, $startDate, $endDate) {
                    $q->where('event_id', $event->id)->where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate]);
                })->count();
                
                $event->gross_revenue = (clone $bookingsQuery)->sum('total_amount');
                $event->organizer_profit = (clone $bookingsQuery)->sum('subtotal_amount');
                
                return $event;
            });

        return view('organizer.reports.sales', compact(
            'totalTickets', 'grossRevenue', 'totalCommission', 'netEarnings',
            'avgOrderValue', 'monthlyTrends', 'eventStats', 'startDate', 'endDate'
        ));
    }

    public function exportSales(Request $request)
    {
        $organizer_id = Auth::id();
        $eventIds = Event::where('user_id', $organizer_id)->pluck('id')->toArray();

        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $bookings = Booking::with('event')
            ->whereIn('event_id', $eventIds)
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "sales_report_" . now()->format('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Fetching event summary data again to ensure it's in the export scope
        $eventStats = Event::where('user_id', $organizer_id)
            ->with(['category'])
            ->get()
            ->map(function($event) use ($startDate, $endDate) {
                $bookingsQuery = Booking::where('event_id', $event->id)
                    ->where('status', 'confirmed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
                
                $event->tickets_sold = \App\Models\BookingAttendee::whereHas('booking', function($q) use ($event, $startDate, $endDate) {
                    $q->where('event_id', $event->id)->where('status', 'confirmed')->whereBetween('created_at', [$startDate, $endDate]);
                })->count();
                
                $event->gross_revenue = (clone $bookingsQuery)->sum('total_amount');
                $event->organizer_profit = (clone $bookingsQuery)->sum('subtotal_amount');
                
                return $event;
            });

        $bookings = Booking::with(['event', 'attendees'])
            ->whereIn('event_id', $eventIds)
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $callback = function() use($eventStats, $bookings) {
            $file = fopen('php://output', 'w');
            
            // Section 1: Event Summary
            fputcsv($file, ['--- EVENT PERFORMANCE SUMMARY ---']);
            fputcsv($file, ['Event Name', 'Category', 'Tickets Sold', 'Gross Revenue', 'Organizer Profit']);
            foreach ($eventStats as $event) {
                fputcsv($file, [
                    $event->title,
                    $event->category->name ?? 'N/A',
                    $event->tickets_sold,
                    '৳' . number_format($event->gross_revenue, 2),
                    '৳' . number_format($event->organizer_profit, 2)
                ]);
            }
            
            fputcsv($file, []); // Spacer
            fputcsv($file, []);

            // Section 2: Transaction Details
            fputcsv($file, ['--- INDIVIDUAL BOOKING TRANSACTIONS ---']);
            fputcsv($file, ['Date', 'Booking ID', 'Event Name', 'Tickets', 'Gross Amount', 'Commission', 'Net Profit']);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d H:i'),
                    $booking->booking_id,
                    $booking->event->title ?? 'N/A',
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
