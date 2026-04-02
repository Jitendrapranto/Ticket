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
    private function getDateRange(Request $request)
    {
        if ($request->has('date_filter') && $request->date_filter !== 'custom') {
            switch ($request->date_filter) {
                case 'today':
                    return [now()->startOfDay(), now()->endOfDay()];
                case 'this_week':
                    return [now()->startOfWeek(), now()->endOfWeek()];
                case 'this_month':
                    return [now()->startOfMonth(), now()->endOfMonth()];
                case 'this_year':
                    return [now()->startOfYear(), now()->endOfYear()];
            }
        }

        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        return [$startDate, $endDate];
    }

    public function sales(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);

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

        // Trends (for Chart) - supports daily, weekly, monthly
        $trendType = $request->input('trend_type', 'monthly');
        $trendsQuery = Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($trendType === 'daily') {
            $trendsQuery->select(
                DB::raw('DATE_FORMAT(created_at, "%b %d") as label'),
                DB::raw('SUM(total_amount) as value'),
                DB::raw('DATE(created_at) as sort_date')
            )
            ->groupBy('label', 'sort_date')
            ->orderBy('sort_date', 'asc');
        } elseif ($trendType === 'weekly') {
            $trendsQuery->select(
                DB::raw('CONCAT("Week ", WEEK(created_at)) as label'),
                DB::raw('SUM(total_amount) as value'),
                DB::raw('MIN(created_at) as sort_date')
            )
            ->groupBy('label')
            ->orderBy('sort_date', 'asc');
        } else {
            // monthly (default)
            $trendsQuery->select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as label'),
                DB::raw('SUM(total_amount) as value'),
                DB::raw('MIN(created_at) as sort_date')
            )
            ->groupBy('label')
            ->orderBy('sort_date', 'asc');
        }
        $trends = $trendsQuery->get();

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

        if ($request->ajax()) {
            return response()->json([
                'labels' => $trends->pluck('label'),
                'values' => $trends->pluck('value'),
            ]);
        }

        return view('admin.reports.sales', compact(
            'totalTickets', 'grossRevenue', 'totalCommission', 'netProfit', 'organizerPayout',
            'avgOrderValue', 'trends', 'eventStats', 'startDate', 'endDate', 'trendType'
        ));
    }

    public function exportSales(Request $request)
    {
        [$startDate, $endDate] = $this->getDateRange($request);

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

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setUpdateFields(true);

        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::cmToEmu(35),
            'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::cmToEmu(21),
            'marginTop' => 800,
            'marginBottom' => 800,
            'marginLeft' => 800,
            'marginRight' => 800,
        ]);

        // Title
        $section->addText(
            'Platform Sales Performance Audit — ' . date('Y-m-d'),
            ['bold' => true, 'size' => 16, 'color' => '1B2B46'],
            ['spaceAfter' => 400, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );

        // --- Section 1: Event Summary ---
        $section->addText('Event Performance Summary', ['bold' => true, 'size' => 12]);
        $styleTable = ['borderSize' => 6, 'borderColor' => 'E2E8F0', 'cellMargin' => 80];
        $styleFirstRow = ['bgColor' => '1B2B46', 'bold' => true];
        $phpWord->addTableStyle('EventSummaryTable', $styleTable, $styleFirstRow);
        $table1 = $section->addTable('EventSummaryTable');

        $headers1 = ['Event Name', 'Organizer', 'Category', 'Tickets Sold', 'Gross Revenue', 'Commission'];
        $colWidths1 = [3500, 2500, 2000, 1500, 2000, 2000];
        $table1->addRow(600);
        foreach ($headers1 as $i => $hdr) {
            $table1->addCell($colWidths1[$i])->addText($hdr, ['bold' => true, 'color' => 'FFFFFF', 'size' => 9]);
        }

        foreach ($eventStats as $event) {
            $table1->addRow(500);
            $table1->addCell($colWidths1[0])->addText($event->title, ['size' => 8]);
            $table1->addCell($colWidths1[1])->addText($event->organizer->name ?? 'N/A', ['size' => 8]);
            $table1->addCell($colWidths1[2])->addText($event->category->name ?? 'N/A', ['size' => 8]);
            $table1->addCell($colWidths1[3])->addText((string)$event->tickets_sold, ['size' => 8]);
            $table1->addCell($colWidths1[4])->addText('৳' . number_format($event->gross_revenue, 2), ['size' => 8]);
            $table1->addCell($colWidths1[5])->addText('৳' . number_format($event->commission, 2), ['size' => 8]);
        }

        $section->addTextBreak(2);

        // --- Section 2: Transaction Details ---
        $section->addText('Detailed Transaction Log', ['bold' => true, 'size' => 12]);
        $phpWord->addTableStyle('TransactionTable', $styleTable, $styleFirstRow);
        $table2 = $section->addTable('TransactionTable');

        $headers2 = ['Date', 'Booking ID', 'Event Name', 'Organizer', 'Tickets', 'Gross', 'Commission', 'Payout'];
        $colWidths2 = [2000, 2000, 3000, 2000, 1000, 1500, 1500, 1500];
        $table2->addRow(600);
        foreach ($headers2 as $i => $hdr) {
            $table2->addCell($colWidths2[$i])->addText($hdr, ['bold' => true, 'color' => 'FFFFFF', 'size' => 9]);
        }

        foreach ($bookings as $booking) {
            $table2->addRow(500);
            $table2->addCell($colWidths2[0])->addText($booking->created_at->format('Y-m-d H:i'), ['size' => 8]);
            $table2->addCell($colWidths2[1])->addText($booking->booking_id, ['size' => 8]);
            $table2->addCell($colWidths2[2])->addText($booking->event->title ?? 'N/A', ['size' => 8]);
            $table2->addCell($colWidths2[3])->addText($booking->event->organizer->name ?? 'N/A', ['size' => 8]);
            $table2->addCell($colWidths2[4])->addText((string)$booking->attendees->count(), ['size' => 8]);
            $table2->addCell($colWidths2[5])->addText('৳' . number_format($booking->total_amount, 2), ['size' => 8]);
            $table2->addCell($colWidths2[6])->addText('৳' . number_format($booking->commission_amount, 2), ['size' => 8]);
            $table2->addCell($colWidths2[7])->addText('৳' . number_format($booking->subtotal_amount, 2), ['size' => 8]);
        }

        // Save to temp file and stream
        $tmpFile = tempnam(sys_get_temp_dir(), 'sales_word_') . '.docx';
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpFile);

        $fileName = 'platform_sales_audit_' . date('Y-m-d') . '.docx';

        $fileContent = file_get_contents($tmpFile);
        @unlink($tmpFile);

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        return response($fileContent, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Length' => strlen($fileContent),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
