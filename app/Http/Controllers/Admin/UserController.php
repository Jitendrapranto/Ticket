<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $customers = $query->with(['bookings'])
            ->withCount(['bookings as tickets_count'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalCustomers = User::where('role', 'user')->count();
        $activeSessions = User::where('role', 'user')->count(); // Mocking as total users for now
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
        if ($customer->role !== 'user') abort(403);
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

        $query = \App\Models\BookingAttendee::with(['booking.event', 'booking.user', 'ticketType']);

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
                  ->orWhere('mobile', 'like', "%$search%");
            });
        }

        $attendees = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.segmentation', compact('attendees', 'events', 'ticketTypes'));
    }

    public function segmentationExport(Request $request)
    {
        $query = \App\Models\BookingAttendee::with(['booking.event', 'booking.user', 'ticketType']);

        if ($request->filled('event_id')) {
            $query->whereHas('booking', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        if ($request->filled('ticket_type_id')) {
            $query->where('ticket_type_id', $request->ticket_type_id);
        }

        $attendees = $query->get();
        $fileName = 'attendees_segmentation_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function() use ($attendees) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Event', 'Attendee Name', 'Mobile', 'Ticket Type', 'Price', 'Status']);

            foreach ($attendees as $item) {
                fputcsv($file, [
                    $item->id, 
                    $item->booking->event->title ?? 'N/A', 
                    $item->name, 
                    $item->mobile, 
                    $item->ticketType->name ?? 'N/A',
                    $item->ticketType->price ?? '0.00',
                    $item->booking->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

    public function destroy(User $customer)
    {
        if ($customer->role !== 'user') abort(403);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully!');
    }
}
