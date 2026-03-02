<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingAttendee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function download($booking_id)
    {
        $booking = Booking::with(['event.category', 'event.formFields', 'attendees.ticketType', 'user'])
            ->where('booking_id', $booking_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Ensure all attendees have ticket numbers
        foreach ($booking->attendees as $attendee) {
            if (!$attendee->ticket_number) {
                $attendee->update([
                    'ticket_number' => 'TKT-' . strtoupper(Str::random(12))
                ]);
            }
        }

        // Generate QR Code as a base64 PNG image (GD is now enabled)
        $qrOptions = new QROptions([
            'outputType'   => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'     => QRCode::ECC_H,
            'scale'        => 10,
            'imageBase64'  => true,
            'addQuietzone' => true,
        ]);
        $qrcode = (new QRCode($qrOptions))->render($booking->booking_id);

        // Prepare Event Banner Image as Base64 for PDF
        $eventImage = null;
        $imgSource = $booking->event->image;

        if ($imgSource) {
            if (filter_var($imgSource, FILTER_VALIDATE_URL)) {
                // Remote URL (e.g. Unsplash)
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $data = @file_get_contents($imgSource, false, $ctx);
                    if ($data !== false) {
                        $finfo = new \finfo(FILEINFO_MIME_TYPE);
                        $mime = $finfo->buffer($data);
                        $eventImage = 'data:' . $mime . ';base64,' . base64_encode($data);
                    }
                } catch (\Exception $e) {
                    $eventImage = null;
                }
            } else {
                // Local file — check multiple common locations
                $paths = [
                    public_path('storage/' . $imgSource),
                    storage_path('app/public/' . $imgSource),
                    public_path($imgSource),
                ];

                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $eventImage = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        break;
                    }
                }
            }
        }

        // Generate PDF (A4)
        $pdf = Pdf::loadView('tickets.ticket', [
            'booking'    => $booking,
            'qrcode'     => $qrcode,
            'eventImage' => $eventImage,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('Ticket-' . $booking->booking_id . '.pdf');
    }
}
