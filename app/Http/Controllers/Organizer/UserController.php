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
        $fileName = 'attendees_segmentation_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($attendees) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Event', 'Attendee Name', 'Email', 'Mobile', 'Ticket Type', 'Status', 'Date', 'Picture URL']);

            foreach ($attendees as $item) {
                $customerPhoto = '';
                if ($item->booking->form_data && $item->booking->event && $item->booking->event->formFields) {
                    $fileFields = $item->booking->event->formFields->where('type', 'file');
                    foreach ($fileFields as $ff) {
                        $val = $item->booking->form_data[$ff->id] ?? null;
                        if ($val && \Storage::disk('public')->exists($val)) {
                            $ext = strtolower(pathinfo($val, PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                                $customerPhoto = url('storage/' . $val);
                            }
                        }
                    }
                }
                if (!$customerPhoto && $item->booking->user && $item->booking->user->profile_picture) {
                    $customerPhoto = url('storage/' . $item->booking->user->profile_picture);
                }

                fputcsv($file, [
                    $item->id, 
                    $item->booking->event->title ?? 'N/A', 
                    $item->name ?: ($item->booking->user->name ?? 'N/A'), 
                    $item->booking->user->email ?? 'N/A',
                    $item->mobile ?: 'N/A', 
                    $item->ticketType->name ?? 'N/A',
                    $item->booking->status,
                    $item->created_at->format('Y-m-d H:i'),
                    $customerPhoto
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
