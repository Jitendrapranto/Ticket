<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventFormField;
use App\Models\TicketType;
use App\Models\Booking;
use App\Models\BookingAttendee;
use App\Models\CommissionSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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

        // Calculate Commission for preview
        $commissionSetting = CommissionSetting::where('is_active', true)->first();
        $commissionAmount = 0;
        if ($commissionSetting) {
            if ($commissionSetting->revenue_model == 'percentage') {
                $commissionAmount = ($totalPrice * $commissionSetting->default_percentage) / 100;
            } else {
                $commissionAmount = $commissionSetting->fixed_amount;
            }
        }
        $finalTotal = $totalPrice + $commissionAmount;

        if ($event->registration_deadline && $event->registration_deadline->isPast()) {
            return redirect()->back()->with('error', 'Registration for this event has closed.');
        }

        $existingBooking = null;
        if (Auth::check()) {
            $existingBooking = Booking::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->where('payment_status', 'unpaid')
                ->first();
        }

        return view('events.booking', compact('event', 'ticketsData', 'totalPrice', 'totalQty', 'commissionAmount', 'commissionSetting', 'finalTotal', 'existingBooking'));
    }

    public function process(Request $request, $slug)
    {
        $event = Event::with('ticketTypes')->where('slug', $slug)->firstOrFail();
        
        if ($event->registration_deadline && $event->registration_deadline->isPast()) {
            return redirect()->route('events.show', $event->slug)->with('error', 'Registration for this event has closed.');
        }
        
        // Basic validation for attendees if provided
        $request->validate([
            'attendees.*.*.name' => 'nullable|string|max:255',
            'attendees.*.*.mobile' => 'nullable|string|max:20',
            'main_ticket_id' => 'required'
        ]);

        $mainTicketId = $request->main_ticket_id;
        $attendeesData = $request->get('attendees', []);
        $formData = $request->get('form_data', []);

        // Handle file uploads from 'file' type form fields
        if ($request->hasFile('form_data_files')) {
            foreach ($request->file('form_data_files') as $fieldId => $file) {
                if ($file->isValid()) {
                    $path = $file->store('form_uploads', 'public');
                    $formData[$fieldId] = $path;
                }
            }
        }

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

                if ($qty > 0) {
                    $totalAmount += ($tier->price * $qty);
                    $ticketSummary[$tier->id] = $qty;
                }
            }

            if ($totalAmount <= 0) {
                throw new \Exception("Invalid ticket selection.");
            }

            // Calculate Commission
            $commissionSetting = CommissionSetting::first();
            $commissionAmount = 0;
            $commissionPercentage = 0;
            
            if ($commissionSetting && $commissionSetting->is_active) {
                if ($commissionSetting->revenue_model == 'percentage') {
                    $commissionPercentage = $commissionSetting->default_percentage;
                    $commissionAmount = ($totalAmount * $commissionPercentage) / 100;
                } else {
                    $commissionAmount = $commissionSetting->fixed_amount;
                }
            }

            $finalTotal = $totalAmount + $commissionAmount;

            // Check for existing pending/unpaid booking to reuse ID
            $booking = Booking::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->where('payment_status', 'unpaid')
                ->first();

            if ($booking) {
                $booking->update([
                    'subtotal_amount' => $totalAmount,
                    'commission_amount' => $commissionAmount,
                    'commission_percentage' => $commissionPercentage,
                    'total_amount' => $finalTotal,
                    'form_data' => $formData
                ]);
                $booking->attendees()->delete();
            } else {
                $booking = Booking::create([
                    'event_id' => $event->id,
                    'user_id' => Auth::id(),
                    'booking_id' => 'TK-' . strtoupper(Str::random(10)),
                    'subtotal_amount' => $totalAmount,
                    'commission_amount' => $commissionAmount,
                    'commission_percentage' => $commissionPercentage,
                    'total_amount' => $finalTotal,
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    'form_data' => $formData
                ]);
            }

            // Save Attendees
            $idOfNameField = $event->formFields()->where('is_default', true)->where('label', 'Name')->first()?->id;
            $idOfPhoneField = $event->formFields()->where('is_default', true)->where('label', 'Phone')->first()?->id;

            foreach ($ticketSummary as $tierId => $qty) {
                for ($i = 1; $i <= $qty; $i++) {
                    // Extract data from form or auth for main person
                    $mainName = $formData[$idOfNameField] ?? Auth::user()->name; 
                    $mainMobile = $formData[$idOfPhoneField] ?? Auth::user()->mobile ?? '';

                    if ($tierId == $mainTicketId && $i == 1) {
                         $name = $mainName;
                         $mobile = $mainMobile;
                    } else {
                        // Use attendee data if provided, otherwise default to main person
                        $name = $attendeesData[$tierId][$i]['name'] ?? $mainName;
                        $mobile = $attendeesData[$tierId][$i]['mobile'] ?? $mainMobile;

                        // Extra safety check for explicitly empty strings
                        if (empty($name)) $name = $mainName;
                        if (empty($mobile)) $mobile = $mainMobile;
                    }

                    BookingAttendee::create([
                        'booking_id' => $booking->id,
                        'ticket_number' => 'TKT-' . strtoupper(Str::random(12)),
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
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->orderBy('sort_order')->get();
        return view('events.checkout', compact('booking', 'paymentMethods'));
    }

    public function complete(Request $request, $booking_id)
    {
        $booking = Booking::where('booking_id', $booking_id)->firstOrFail();
        
        $request->validate([
            'payment_method' => 'required',
            'transaction_id' => 'required|string',
            'payment_number' => 'required|string',
            'payment_screenshot' => 'nullable|image|max:2048'
        ]);

        // Global check for Unique Transaction ID
        $exists = Booking::where('transaction_id', $request->transaction_id)
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'This Transaction ID has already been used. Please provide a valid one.');
        }

        $screenshotPath = $booking->payment_screenshot;
        if ($request->hasFile('payment_screenshot')) {
            $screenshotPath = $request->file('payment_screenshot')->store('screenshots', 'public');
        }

        $method = \App\Models\PaymentMethod::where('slug', $request->payment_method)->first();

        $booking->update([
            'payment_method' => $request->payment_method,
            'payment_method_name' => $method ? $method->name : $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'payment_number' => $request->payment_number,
            'payment_screenshot' => $screenshotPath,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        return redirect()->route('bookings.index')->with('booking_success', 'Booking submitted successfully! Our team will verify your payment soon.');
    }
}
