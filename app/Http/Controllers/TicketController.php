<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function download($booking_id)
    {
        try {
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

            // Generate QR Code for each attendee (unique per ticket)
            $qrOptions = new QROptions([
                'outputType'   => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'     => QRCode::ECC_H,
                'scale'        => 10,
                'imageBase64'  => true,
                'addQuietzone' => true,
            ]);
            $qrGenerator = new QRCode($qrOptions);

            // Main booking QR code
            $qrcode = $qrGenerator->render($booking->booking_id);

            // Per-attendee QR codes
            $attendeeQRCodes = [];
            foreach ($booking->attendees as $attendee) {
                $qrData = $attendee->ticket_number ?? $booking->booking_id;
                $attendeeQRCodes[$attendee->id] = $qrGenerator->render($qrData);
            }

            // Prepare Event Banner Image as Base64 for PDF
            $eventImage = $this->getEventImageBase64($booking->event->image);
            
            // Prepare User Avatar as Base64
            $userAvatar = $this->getEventImageBase64($booking->user->avatar);

            // Fetch Site Logo
            $siteHeader = \App\Models\SiteHeader::first();
            $logoPath = $siteHeader && $siteHeader->logo_path
                ? (str_starts_with($siteHeader->logo_path, 'site/') ? 'storage/' . $siteHeader->logo_path : $siteHeader->logo_path)
                : 'Blue_Simple_Technology_Logo.png';
            $siteLogo = $this->getEventImageBase64($logoPath);

            // Prepare Form Uploaded Images as Base64
            $formImages = [];
            $formData = $booking->form_data ?? [];
            foreach ($booking->event->formFields as $field) {
                if ($field->type === 'file' && isset($formData[$field->id])) {
                    $filePath = $formData[$field->id];
                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                        $formImages[$field->id] = $this->getEventImageBase64($filePath);
                    }
                }
            }

            // Generate PDF (A4)
            $pdf = Pdf::loadView('tickets.ticket', [
                'booking'        => $booking,
                'qrcode'         => $qrcode,
                'eventImage'     => $eventImage,
                'userAvatar'     => $userAvatar,
                'siteLogo'       => $siteLogo,
                'formImages'     => $formImages,
                'attendeeQRCodes' => $attendeeQRCodes,
            ])->setPaper('a4', 'portrait');

            // Use stream for better compatibility on live servers
            $filename = 'Ticket-' . $booking->booking_id . '.pdf';
            
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
            
        } catch (\Exception $e) {
            Log::error('PDF Download Error: ' . $e->getMessage(), [
                'booking_id' => $booking_id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Unable to generate PDF. Please try again or contact support.');
        }
    }

    /**
     * Get event image as base64 string for PDF embedding
     */
    private function getEventImageBase64($imgSource)
    {
        if (!$imgSource) {
            return null;
        }

        try {
            // Check if it's a remote URL
            if (filter_var($imgSource, FILTER_VALIDATE_URL)) {
                return $this->fetchRemoteImage($imgSource);
            }

            // Local file - try multiple paths
            $possiblePaths = [
                public_path('storage/' . $imgSource),
                storage_path('app/public/' . $imgSource),
                public_path($imgSource),
                base_path('public/storage/' . $imgSource),
            ];

            foreach ($possiblePaths as $path) {
                // Normalize path for cross-platform compatibility
                $normalizedPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
                
                if (file_exists($normalizedPath) && is_readable($normalizedPath)) {
                    $data = file_get_contents($normalizedPath);
                    if ($data !== false) {
                        $mime = $this->getMimeType($normalizedPath);
                        return 'data:' . $mime . ';base64,' . base64_encode($data);
                    }
                }
            }

            // Try using Laravel's Storage facade
            if (Storage::disk('public')->exists($imgSource)) {
                $data = Storage::disk('public')->get($imgSource);
                if ($data !== false) {
                    $extension = pathinfo($imgSource, PATHINFO_EXTENSION);
                    $mimeTypes = [
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        'webp' => 'image/webp',
                    ];
                    $mime = $mimeTypes[strtolower($extension)] ?? 'image/jpeg';
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }

            Log::warning('Event image not found', ['image' => $imgSource]);
            return null;

        } catch (\Exception $e) {
            Log::warning('Failed to load event image: ' . $e->getMessage(), ['image' => $imgSource]);
            return null;
        }
    }

    /**
     * Fetch remote image with proper SSL handling for live servers
     */
    private function fetchRemoteImage($url)
    {
        try {
            // Use cURL for better compatibility on live servers
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 3,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; TicketApp/1.0)',
                ]);

                $data = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                curl_close($ch);

                if ($httpCode === 200 && $data !== false) {
                    // Extract mime type from content-type header
                    $mime = explode(';', $contentType)[0] ?? 'image/jpeg';
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }

            // Fallback to file_get_contents with context
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Mozilla/5.0 (compatible; TicketApp/1.0)',
                ],
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                ],
            ]);

            $data = @file_get_contents($url, false, $context);
            if ($data !== false) {
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->buffer($data);
                return 'data:' . $mime . ';base64,' . base64_encode($data);
            }

            return null;

        } catch (\Exception $e) {
            Log::warning('Failed to fetch remote image: ' . $e->getMessage(), ['url' => $url]);
            return null;
        }
    }

    /**
     * Get MIME type of a file
     */
    private function getMimeType($path)
    {
        if (function_exists('mime_content_type')) {
            return mime_content_type($path);
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        return $mimeTypes[$extension] ?? 'image/jpeg';
    }
}
