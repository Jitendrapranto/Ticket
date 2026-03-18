<?php
// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Booking;
use App\Models\BookingAttendee;
use Illuminate\Support\Str;

echo "=== Fixing Bookings Without Attendees ===\n\n";

$bookings = Booking::with(['event.ticketTypes', 'user'])
    ->whereDoesntHave('attendees')
    ->get();

echo "Found " . $bookings->count() . " bookings with no attendees.\n\n";

foreach ($bookings as $booking) {
    echo "Booking: " . $booking->booking_id . " (ID: " . $booking->id . ")\n";
    echo "  Event: " . ($booking->event->title ?? 'N/A') . "\n";
    echo "  User: " . ($booking->user->name ?? 'Unknown') . "\n";
    echo "  Subtotal: " . $booking->subtotal_amount . "\n";
    echo "  Status: " . $booking->status . " / " . $booking->payment_status . "\n";

    // Find the ticket type that would make sense for this booking
    $event = $booking->event;
    if (!$event) {
        echo "  ERROR: No event found, skipping.\n\n";
        continue;
    }

    $ticketTypes = $event->ticketTypes;
    if ($ticketTypes->isEmpty()) {
        echo "  ERROR: No ticket types found, skipping.\n\n";
        continue;
    }

    // Figure out how many tickets were bought based on subtotal
    $remaining = (float) $booking->subtotal_amount;
    $created = 0;

    foreach ($ticketTypes as $tt) {
        if ($tt->price > 0 && $remaining >= $tt->price) {
            $qty = (int) floor($remaining / $tt->price);
            for ($i = 0; $i < $qty; $i++) {
                BookingAttendee::create([
                    'booking_id' => $booking->id,
                    'ticket_number' => 'TKT-' . strtoupper(Str::random(12)),
                    'ticket_type_id' => $tt->id,
                    'name' => $booking->user->name ?? 'Guest',
                    'mobile' => $booking->user->mobile ?? '',
                ]);
                $remaining -= $tt->price;
                $created++;
            }
        } elseif ($tt->price == 0) {
            // Free ticket — create 1 attendee
            BookingAttendee::create([
                'booking_id' => $booking->id,
                'ticket_number' => 'TKT-' . strtoupper(Str::random(12)),
                'ticket_type_id' => $tt->id,
                'name' => $booking->user->name ?? 'Guest',
                'mobile' => $booking->user->mobile ?? '',
            ]);
            $created++;
        }
    }

    // If no attendees computed from price, create at least 1 with the first ticket type
    if ($created === 0) {
        $firstType = $ticketTypes->first();
        BookingAttendee::create([
            'booking_id' => $booking->id,
            'ticket_number' => 'TKT-' . strtoupper(Str::random(12)),
            'ticket_type_id' => $firstType->id,
            'name' => $booking->user->name ?? 'Guest',
            'mobile' => $booking->user->mobile ?? '',
        ]);
        $created = 1;
    }

    echo "  Created " . $created . " attendee(s) with ticket numbers.\n\n";
}

echo "=== Done! ===\n";
