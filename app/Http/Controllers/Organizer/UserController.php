<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use App\Models\BookingAttendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = Auth::id();
        $myEventIds = Event::where('user_id', $organizerId)->pluck('id');

        // Customers who have booked for this organizer's events
        $query = User::whereHas('bookings', function($q) use ($myEventIds) {
            $q->whereIn('event_id', $myEventIds);
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $customers = $query->withCount(['bookings' => function($q) use ($myEventIds) {
            $q->whereIn('event_id', $myEventIds);
        }])
        ->latest()
        ->paginate(15)
        ->withQueryString();

        $totalCustomers = (clone $query)->count();
        $totalBookings = Booking::whereIn('event_id', $myEventIds)->where('status', 'confirmed')->count();
        $totalRevenue = Booking::whereIn('event_id', $myEventIds)->where('status', 'confirmed')->sum('subtotal_amount'); // Organizer's portion
        $averageLTV = $totalCustomers > 0 ? $totalRevenue / $totalCustomers : 0;

        return view('organizer.customers.index', compact('customers', 'totalCustomers', 'totalBookings', 'averageLTV'));
    }

    public function segmentation(Request $request)
    {
        $organizerId = Auth::id();
        $events = Event::where('user_id', $organizerId)->orderBy('title')->get();
        $myEventIds = $events->pluck('id');

        $query = BookingAttendee::with(['booking.event.formFields', 'booking.user', 'ticketType'])
            ->whereHas('booking', function($q) use ($myEventIds) {
                $q->whereIn('event_id', $myEventIds);
            });

        if ($request->filled('event_id')) {
            $query->whereHas('booking', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('mobile', 'like', "%$search%")
                  ->orWhereHas('booking.user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  });
            });
        }

        $attendees = $query->latest()->paginate(15)->withQueryString();

        return view('organizer.customers.segmentation', compact('attendees', 'events'));
    }

    public function segmentationExport(Request $request)
    {
        $organizerId = Auth::id();
        $myEventIds = Event::where('user_id', $organizerId)->pluck('id');

        $query = BookingAttendee::with(['booking.event.formFields', 'booking.user', 'ticketType'])
            ->whereHas('booking', function($q) use ($myEventIds) {
                $q->whereIn('event_id', $myEventIds);
            });

        if ($request->filled('event_id')) {
            $query->whereHas('booking', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('mobile', 'like', "%$search%")
                  ->orWhereHas('booking.user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  });
            });
        }

        $attendees = $query->get();

        // --- Build Word Document ---
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setUpdateFields(true);

        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::cmToEmu(35),
            'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::cmToEmu(21),
            'marginTop'    => 800,
            'marginBottom' => 800,
            'marginLeft'   => 800,
            'marginRight'  => 800,
        ]);

        // Title
        $section->addText(
            'Attendee Segmentation Report — ' . date('Y-m-d'),
            ['bold' => true, 'size' => 14],
            ['spaceAfter' => 200]
        );

        // Table style
        $phpWord->addTableStyle('SegTable', [
            'borderSize' => 6,
            'borderColor' => 'cccccc',
            'cellMargin' => 80,
        ], [
            'bgColor' => '4F0B67',
            'color'   => 'ffffff',
            'bold'    => true,
        ]);

        $table = $section->addTable('SegTable');

        // Header row
        $headers = ['ID', 'Event', 'Attendee Name', 'Email', 'Mobile', 'Ticket Type', 'Status', 'Date', 'Photo'];
        $colWidths = [700, 2400, 2000, 2400, 1400, 1600, 1200, 1600, 1800];
        $table->addRow(500);
        foreach ($headers as $i => $hdr) {
            $cell = $table->addCell($colWidths[$i], ['bgColor' => '4F0B67']);
            $cell->addText($hdr, ['bold' => true, 'color' => 'ffffff', 'size' => 9]);
        }

        // Data rows
        foreach ($attendees as $item) {
            $storagePath = null;

            if ($item->booking->form_data && $item->booking->event && $item->booking->event->formFields) {
                $fileFields = $item->booking->event->formFields->where('type', 'file');
                foreach ($fileFields as $ff) {
                    $val = $item->booking->form_data[$ff->id] ?? null;
                    if ($val && \Storage::disk('public')->exists($val)) {
                        $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                            $storagePath = $val;
                        }
                    }
                }
            }
            if (!$storagePath && $item->booking->user && $item->booking->user->profile_picture) {
                $pp = $item->booking->user->profile_picture;
                if (\Storage::disk('public')->exists($pp)) {
                    $storagePath = $pp;
                }
            }

            $table->addRow(1400);
            $cellStyle = ['valign' => 'center'];
            $textStyle = ['size' => 9];

            $table->addCell($colWidths[0], $cellStyle)->addText((string)$item->id, $textStyle);
            $table->addCell($colWidths[1], $cellStyle)->addText($item->booking->event->title ?? 'N/A', $textStyle);
            $table->addCell($colWidths[2], $cellStyle)->addText($item->name ?: ($item->booking->user->name ?? 'N/A'), $textStyle);
            $table->addCell($colWidths[3], $cellStyle)->addText($item->booking->user->email ?? 'N/A', $textStyle);
            $table->addCell($colWidths[4], $cellStyle)->addText($item->mobile ?: 'N/A', $textStyle);
            $table->addCell($colWidths[5], $cellStyle)->addText($item->ticketType->name ?? 'N/A', $textStyle);
            $table->addCell($colWidths[6], $cellStyle)->addText($item->booking->status ?? 'N/A', $textStyle);
            $table->addCell($colWidths[7], $cellStyle)->addText($item->created_at->format('Y-m-d H:i'), $textStyle);

            $photoCell = $table->addCell($colWidths[8], $cellStyle);
            if ($storagePath) {
                $absolutePath = \Storage::disk('public')->path($storagePath);
                if (file_exists($absolutePath)) {
                    try {
                        $photoCell->addImage($absolutePath, ['width' => 70, 'height' => 70, 'wrappingStyle' => 'inline']);
                    } catch (\Exception $e) {
                        $photoCell->addText('(image error)', $textStyle);
                    }
                } else {
                    $photoCell->addText('N/A', $textStyle);
                }
            } else {
                $photoCell->addText('N/A', $textStyle);
            }
        }

        // Save to temp file and stream
        $tmpFile = tempnam(sys_get_temp_dir(), 'seg_word_') . '.docx';
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpFile);

        $fileName = 'attendees_segmentation_' . date('Y-m-d') . '.docx';

        return response()->download($tmpFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    public function export(Request $request)
    {
        $organizerId = Auth::id();
        $myEventIds = Event::where('user_id', $organizerId)->pluck('id');

        $query = User::whereHas('bookings', function($q) use ($myEventIds) {
            $q->whereIn('event_id', $myEventIds);
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $customers = $query->withCount(['bookings' => function($q) use ($myEventIds) {
            $q->whereIn('event_id', $myEventIds);
        }])->get();

        $fileName = 'customers_export_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Bookings Count', 'Joined Date']);

            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id, 
                    $customer->name, 
                    $customer->email, 
                    $customer->bookings_count,
                    $customer->created_at->format('Y-m-d')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show($id)
    {
        $organizerId = Auth::id();
        $myEventIds = Event::where('user_id', $organizerId)->pluck('id');

        $user = User::whereHas('bookings', function($q) use ($myEventIds) {
            $q->whereIn('event_id', $myEventIds);
        })->findOrFail($id);

        $bookings = Booking::with(['event'])
            ->where('user_id', $id)
            ->whereIn('event_id', $myEventIds)
            ->latest()
            ->get();

        return view('organizer.customers.show', compact('user', 'bookings'));
    }
}
