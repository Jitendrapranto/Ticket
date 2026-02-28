<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventFormField;
use App\Models\Booking;
use App\Models\BookingAttendee;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function show(Request $request, $slug)
    {
        $event = Event::with(['ticketTypes', 'formFields'])->where('slug', $slug)->firstOrFail();
        
        $selectedTickets = $request->get('tickets', []);
        $ticketsData = [];
        $totalPrice = 0;
        $totalQty = 0;

        foreach ($selectedTickets as $id => $qty) {
            if ($qty > 0) {
                $ticketType = $event->ticketTypes->find($id);
                if ($ticketType) {
                    $ticketsData[] = [
                        'id' => $id,
                        'name' => $ticketType->name,
                        'price' => $ticketType->price,
                        'quantity' => $qty
                    ];
                    $totalPrice += ($ticketType->price * $qty);
                    $totalQty += $qty;
                }
            }
        }

        if ($totalQty === 0) {
            return redirect()->back()->with('error', 'Please select at least one ticket.');
        }

        // Redirect if total qty > 4 (security/server-side check)
        if ($totalQty > 4) {
             return redirect()->back()->with('error', 'You can only book up to 4 tickets.');
        }

        return view('events.booking', compact('event', 'ticketsData', 'totalPrice', 'totalQty'));
    }

    public function process(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('signup')->with('info', 'Please create an account or login to complete your booking.');
        }

        $event = Event::with('ticketTypes')->where('slug', $slug)->firstOrFail();
        
        // Basic validation for attendees if provided
        $request->validate([
            'attendees.*.*.name' => 'nullable|string|max:255',
            'attendees.*.*.mobile' => 'nullable|string|max:20',
            'main_ticket_id' => 'required'
        ]);

        $mainTicketId = $request->main_ticket_id;
        $attendeesData = $request->get('attendees', []);
        $formData = $request->get('form_data', []);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $ticketSummary = [];
            
            // Re-calculate total and verify tickets exist for this event
            foreach ($event->ticketTypes as $tier) {
                $qtyKey = "tickets[{$tier->id}]";
                // Since tickets come from URL params in the previous step, we might need a better way to track them.
                // For now, let's assume the attendees data reflects the intended quantity.
                $qty = 0;
                if (isset($attendeesData[$tier->id])) {
                    $qty = count($attendeesData[$tier->id]);
                }
                
                // If it's the main ticket, add the 1 we hid from the UI
                if ($tier->id == $mainTicketId) {
                    $qty += 1;
                }

                if ($qty > 0) {
                    $totalAmount += ($tier->price * $qty);
                    $ticketSummary[$tier->id] = $qty;
                }
            }

            if ($totalAmount <= 0) {
                throw new \Exception("Invalid ticket selection.");
            }

            $booking = Booking::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'booking_id' => 'TK-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'form_data' => $formData
            ]);

            // Save Attendees
            $idOfNameField = $event->formFields()->where('is_default', true)->where('label', 'Name')->first()?->id;
            $idOfPhoneField = $event->formFields()->where('is_default', true)->where('label', 'Phone')->first()?->id;

            foreach ($ticketSummary as $tierId => $qty) {
                for ($i = 1; $i <= $qty; $i++) {
                    $name = '';
                    $mobile = '';

                    if ($tierId == $mainTicketId && $i == 1) {
                         // Default to Form Data Name/Email if it's the main person
                         $name = $formData[$idOfNameField] ?? 'Self'; 
                         $mobile = $formData[$idOfPhoneField] ?? '';
                    } else {
                        $name = $attendeesData[$tierId][$i]['name'] ?? '';
                        $mobile = $attendeesData[$tierId][$i]['mobile'] ?? '';
                    }

                    BookingAttendee::create([
                        'booking_id' => $booking->id,
                        'ticket_type_id' => $tierId,
                        'name' => $name,
                        'mobile' => $mobile
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('events.checkout', $booking->booking_id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }

    public function checkout($booking_id)
    {
        $booking = Booking::with(['event', 'attendees.ticketType'])->where('booking_id', $booking_id)->firstOrFail();
        return view('events.checkout', compact('booking'));
    }

    public function complete(Request $request, $booking_id)
    {
        $booking = Booking::where('booking_id', $booking_id)->firstOrFail();
        
        $request->validate([
            'payment_method' => 'required|in:bkash,card,cod'
        ]);

        $booking->update([
            'payment_method' => $request->payment_method,
            'status' => $request->payment_method === 'cod' ? 'confirmed' : 'pending',
            'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'pending' // COD is unpaid until arrival
        ]);

        return redirect()->route('bookings.index')->with('booking_success', 'Ticket Booked Successfully!');
    }
}
