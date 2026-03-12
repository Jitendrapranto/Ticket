<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Date filtering
        if ($request->filled('date_filter')) {
            $now = now();
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [$now->startOfWeek()->startOfDay(), now()->endOfWeek()->endOfDay()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', $now->year);
                    break;
                case 'custom':
                    if ($request->filled('date_from')) {
                        $query->whereDate('created_at', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $query->whereDate('created_at', '<=', $request->date_to);
                    }
                    break;
            }
        }

        $customers = $query->with(['bookings'])
            ->withCount(['bookings as tickets_count'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalCustomers = User::where('role', '!=', 'admin')->count();
        $activeSessions = User::where('role', '!=', 'admin')->count(); // Mocking as total users for now
        $totalRevenue = \App\Models\Booking::where('status', 'confirmed')->sum('total_amount');
        $averageLTV = $totalCustomers > 0 ? $totalRevenue / $totalCustomers : 0;

        return view('admin.users.index', compact('customers', 'totalCustomers', 'activeSessions', 'averageLTV'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully!');
    }

    public function show(User $customer)
    {
        if ($customer->role === 'admin') abort(403);
        return view('admin.users.show', ['user' => $customer]);
    }

    public function export()
    {
        $customers = User::where('role', 'user')->get();
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
            fputcsv($file, ['ID', 'Name', 'Email', 'Joined Date']);

            foreach ($customers as $customer) {
                fputcsv($file, [$customer->id, $customer->name, $customer->email, $customer->created_at->format('Y-m-d')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function segmentation(Request $request)
    {
        $events = \App\Models\Event::orderBy('title')->get();
        $ticketTypes = \App\Models\TicketType::orderBy('name')->get();

        $query = \App\Models\BookingAttendee::with(['booking.event.formFields', 'booking.user', 'ticketType']);

        if ($request->filled('event_id')) {
            $query->whereHas('booking', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        if ($request->filled('ticket_type_id')) {
            $query->where('ticket_type_id', $request->ticket_type_id);
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

        return view('admin.users.segmentation', compact('attendees', 'events', 'ticketTypes'));
    }

    public function segmentationExport(Request $request)
{
    $query = \App\Models\BookingAttendee::with(['booking.event.formFields', 'booking.user', 'ticketType']);

    if ($request->filled('event_id')) {
        $query->whereHas('booking', function($q) use ($request) {
            $q->where('event_id', $request->event_id);
        });
    }

    if ($request->filled('ticket_type_id')) {
        $query->where('ticket_type_id', $request->ticket_type_id);
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
    $headers = ['ID', 'Event', 'Attendee Name', 'Email', 'Mobile', 'Ticket Type', 'Status', 'Photo'];
    $colWidths = [700, 2400, 2000, 2400, 1400, 1600, 1200, 1800];
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

        $photoCell = $table->addCell($colWidths[7], $cellStyle);
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

    public function segmentationEdit($id)
    {
        $attendee = \App\Models\BookingAttendee::with(['booking.event', 'ticketType'])->findOrFail($id);
        return view('admin.users.segmentation_edit', compact('attendee'));
    }

    public function segmentationUpdate(Request $request, $id)
    {
        $attendee = \App\Models\BookingAttendee::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
        ]);

        $attendee->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
        ]);

        return redirect()->route('admin.customers.segmentation')->with('success', 'Attendee updated successfully!');
    }

    public function segmentationDelete($id)
    {
        $attendee = \App\Models\BookingAttendee::findOrFail($id);
        $attendee->delete();

        return redirect()->route('admin.customers.segmentation')->with('success', 'Attendee removed from segment successfully!');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') abort(403);

        $request->validate([
            'password' => 'required|string|min:8'
        ]);

        $user->update([
            'password' => \Hash::make($request->password)
        ]);

        return back()->with('success', "Password for {$user->name} has been updated successfully.");
    }

    public function destroy(User $customer)
    {
        if ($customer->role === 'admin') abort(403);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully!');
    }
}
