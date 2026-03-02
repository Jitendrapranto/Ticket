<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket #{{ $booking->booking_id }}</title>
    <style>
        @page { margin: 0; size: a4 portrait; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0; padding: 0;
            color: #1e293b;
            background: #fff;
        }

        /* ===== TOP: EVENT BANNER ===== */
        .event-banner {
            width: 100%;
            height: 260px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #520C6B 0%, #2563EB 100%);
        }
        .event-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .event-banner .gradient-overlay {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
        }

        /* ===== TITLE BAR ===== */
        .title-bar {
            background: #520C6B;
            padding: 18px 40px;
            color: #fff;
        }
        .title-bar h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .title-bar .subtitle {
            margin: 3px 0 0;
            font-size: 10px;
            opacity: 0.7;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* ===== STATUS PILL ===== */
        .confirmed-strip {
            background: #f0fdf4;
            border-bottom: 1px solid #bbf7d0;
            padding: 10px 40px;
            font-size: 12px;
            font-weight: 800;
            color: #166534;
        }

        /* ===== BOTTOM: DETAILS ===== */
        .details-area { padding: 25px 40px 15px; }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .info-grid td {
            vertical-align: top;
            padding: 0;
        }

        .section-title {
            font-size: 10px;
            font-weight: 900;
            color: #520C6B;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 0 0 14px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #e2e8f0;
        }

        .field { margin-bottom: 14px; }
        .field-label {
            display: block;
            font-size: 8px;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .field-value {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        /* ===== QR CODE ===== */
        .qr-box {
            width: 180px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 15px;
            text-align: center;
        }
        .qr-box img {
            width: 130px;
            height: 130px;
            display: block;
            margin: 0 auto 10px;
        }
        .qr-box .qr-label {
            font-size: 10px;
            font-weight: 900;
            color: #520C6B;
            font-family: monospace;
        }
        .qr-box .qr-hint {
            font-size: 7px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* ===== MINI STATS ===== */
        .stats-row {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin: 20px 0 0 -8px;
        }
        .stat-card {
            padding: 12px 14px;
            border-radius: 10px;
            color: #fff;
            width: 25%;
        }
        .stat-card .stat-label {
            display: block;
            font-size: 7px;
            font-weight: 900;
            text-transform: uppercase;
            opacity: 0.85;
            margin-bottom: 3px;
        }
        .stat-card .stat-value {
            font-size: 12px;
            font-weight: 900;
        }
        .bg-emerald { background: #10b981; }
        .bg-violet  { background: #8b5cf6; }
        .bg-rose    { background: #f43f5e; }
        .bg-sky     { background: #0ea5e9; }

        /* ===== TERMS ===== */
        .terms {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 16px 20px;
            margin-top: 20px;
            font-size: 8px;
            color: #64748b;
            line-height: 1.5;
        }
        .terms strong {
            display: block;
            font-size: 10px;
            color: #0f172a;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .terms ul { margin: 0; padding-left: 14px; }
        .terms li { margin-bottom: 3px; }

        /* ===== FOOTER ===== */
        .page-footer {
            background: #0f172a;
            color: #fff;
            text-align: center;
            padding: 12px;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <!-- ========== TOP: EVENT BANNER ========== -->
    <div class="event-banner">
        @if($eventImage)
            <img src="{{ $eventImage }}" alt="Event Banner">
            <div class="gradient-overlay"></div>
        @endif
    </div>

    <!-- ========== TITLE BAR ========== -->
    <div class="title-bar">
        <h1>{{ $booking->event->title }}</h1>
        <p class="subtitle">{{ $booking->event->category->name ?? 'Event' }} &bull; Official Admission Pass</p>
    </div>

    <!-- ========== CONFIRMATION STRIP ========== -->
    <div class="confirmed-strip">
        &#10003; Booking Confirmed &mdash; Order #{{ $booking->booking_id }}
    </div>

    <!-- ========== BOTTOM: DETAILS + QR ========== -->
    <div class="details-area">
        <table class="info-grid">
            <tr>
                <!-- Column 1: Event Details -->
                <td style="width: 33%; padding-right: 20px;">
                    <p class="section-title">Event Details</p>
                    <div class="field">
                        <span class="field-label">Venue</span>
                        <span class="field-value">{{ $booking->event->venue_name ?? $booking->event->location }}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Date</span>
                        <span class="field-value">{{ $booking->event->date->format('l, F d, Y') }}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Category</span>
                        <span class="field-value">{{ $booking->event->category->name ?? 'General' }}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Pass Type</span>
                        <span class="field-value">
                            @foreach($booking->attendees->groupBy('ticket_type_id') as $tier)
                                {{ $tier->count() }}&times; {{ $tier->first()->ticketType->name }}@if(!$loop->last), @endif
                            @endforeach
                        </span>
                    </div>
                </td>

                <!-- Column 2: Customer Details -->
                <td style="width: 33%; padding-right: 20px;">
                    <p class="section-title">Registration Info</p>
                    @php
                        $formData = $booking->form_data ?? [];
                        $formFields = $booking->event->formFields ?? collect();
                        $displayCount = 0;
                    @endphp

                    @foreach($formFields as $field)
                        @if(isset($formData[$field->id]) && !empty($formData[$field->id]) && $displayCount < 5)
                            <div class="field">
                                <span class="field-label">{{ $field->label }}</span>
                                <span class="field-value">
                                    @if($field->type === 'file')
                                        [Uploaded File]
                                    @else
                                        {{ $formData[$field->id] }}
                                    @endif
                                </span>
                            </div>
                            @php $displayCount++; @endphp
                        @endif
                    @endforeach

                    @if($displayCount == 0)
                        <div class="field">
                            <span class="field-label">Name</span>
                            <span class="field-value">{{ $booking->user->name }}</span>
                        </div>
                        <div class="field">
                            <span class="field-label">Email</span>
                            <span class="field-value">{{ $booking->user->email }}</span>
                        </div>
                    @endif
                    
                    <div class="field">
                        <span class="field-label">Booking Date</span>
                        <span class="field-value">{{ $booking->created_at->format('M d, Y') }}</span>
                    </div>
                </td>

                <!-- Column 3: QR Code -->
                <td style="width: 34%;">
                    <p class="section-title" style="text-align: center;">Unique QR Code</p>
                    <div class="qr-box">
                        <img src="{{ $qrcode }}" alt="QR Code">
                        <span class="qr-label">{{ $booking->booking_id }}</span>
                        <p class="qr-hint">Present this code at entry</p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Mini Stats -->
        <table class="stats-row">
            <tr>
                <td class="stat-card bg-emerald">
                    <span class="stat-label">Payment</span>
                    <span class="stat-value">&#2547;{{ number_format($booking->total_amount, 2) }}</span>
                </td>
                <td class="stat-card bg-violet">
                    <span class="stat-label">Order Ref</span>
                    <span class="stat-value">{{ substr($booking->booking_id, -8) }}</span>
                </td>
                <td class="stat-card bg-rose">
                    <span class="stat-label">Event Date</span>
                    <span class="stat-value">{{ $booking->event->date->format('M d, Y') }}</span>
                </td>
                <td class="stat-card bg-sky">
                    <span class="stat-label">Status</span>
                    <span class="stat-value">CONFIRMED</span>
                </td>
            </tr>
        </table>

        <!-- Terms -->
        <div class="terms">
            <strong>Terms &amp; Conditions</strong>
            <ul>
                <li>Please arrive 30 minutes before the event start time for smooth entry.</li>
                <li>A printed or digital copy of this ticket must be presented at the registration desk.</li>
                <li>Each QR code is unique and valid for a single scan only. Do not share or duplicate.</li>
                <li>The organizer reserves the right of admission based on venue capacity and security policies.</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="page-footer">
        Thank you for choosing Ticket Kinun &bull; www.ticketkinun.com
    </div>

</body>
</html>
