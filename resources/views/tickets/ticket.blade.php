<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket #{{ $booking->booking_id }}</title>
    <style>
        @page { margin: 0; size: a4 portrait; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0; padding: 0;
            color: #1e293b;
            background: #ffffff;
        }

        /* ===== EVENT BANNER ===== */
        .event-banner {
            width: 100%;
            height: 220px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #520C6B 0%, #21032B 100%);
        }
        .event-banner img {
            width: 100%;
            height: 220px;
        }
        .banner-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(180deg, rgba(82,12,107,0.3) 0%, rgba(33,3,43,0.7) 100%);
        }
        .banner-badge {
            position: absolute;
            top: 16px; left: 16px;
            background: #520C6B;
            color: #fff;
            font-size: 8px;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 4px;
        }
        .banner-logo {
            position: absolute;
            top: 16px; right: 16px;
            color: #fff;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* ===== TITLE SECTION ===== */
        .title-section {
            background: linear-gradient(135deg, #520C6B 0%, #3b0764 100%);
            padding: 20px 35px;
            color: #fff;
        }
        .title-section h1 {
            margin: 0 0 4px 0;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .title-meta {
            font-size: 10px;
            color: rgba(255,255,255,0.7);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* ===== BOOKING STATUS ===== */
        .status-bar {
            background: #f0fdf4;
            border-bottom: 2px solid #bbf7d0;
            padding: 10px 35px;
            font-size: 11px;
            font-weight: 800;
            color: #166534;
            letter-spacing: 0.5px;
        }
        .status-bar .check {
            color: #16a34a;
            font-weight: 900;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding: 22px 35px 10px;
        }

        /* ===== INFO GRID (Table-based for DomPDF) ===== */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 0;
        }

        .section-heading {
            font-size: 9px;
            font-weight: 900;
            color: #520C6B;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f1f5f9;
            margin-bottom: 14px;
        }

        .info-field {
            margin-bottom: 12px;
        }
        .info-label {
            display: block;
            font-size: 7px;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
        }
        .info-value-accent {
            font-size: 12px;
            font-weight: 900;
            color: #520C6B;
            line-height: 1.3;
        }

        /* ===== QR CODE BOX ===== */
        .qr-container {
            text-align: center;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            padding: 16px 12px;
            background: #faf5ff;
        }
        .qr-container img {
            width: 140px;
            height: 140px;
            margin: 0 auto;
        }
        .qr-ticket-number {
            font-size: 9px;
            font-weight: 900;
            color: #520C6B;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
            margin-top: 8px;
        }
        .qr-scan-text {
            font-size: 7px;
            color: #94a3b8;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        /* ===== ATTENDEE TABLE ===== */
        .attendee-heading {
            font-size: 9px;
            font-weight: 900;
            color: #520C6B;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 18px 0 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #f1f5f9;
        }
        .attendee-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .attendee-table th {
            background: #520C6B;
            color: #fff;
            font-size: 7px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 8px 10px;
            text-align: left;
        }
        .attendee-table th:first-child {
            border-radius: 6px 0 0 0;
        }
        .attendee-table th:last-child {
            border-radius: 0 6px 0 0;
        }
        .attendee-table td {
            padding: 8px 10px;
            font-size: 10px;
            font-weight: 600;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .attendee-table tr:nth-child(even) td {
            background: #faf5ff;
        }
        .ticket-num-cell {
            font-family: 'Courier New', monospace;
            font-size: 8px;
            font-weight: 800;
            color: #520C6B;
        }

        /* ===== STATS ROW ===== */
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 0;
            margin: 16px 0 0 -6px;
        }
        .stat-box {
            padding: 10px 12px;
            border-radius: 8px;
            color: #fff;
            width: 25%;
        }
        .stat-box .s-label {
            display: block;
            font-size: 6px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.85;
            margin-bottom: 2px;
        }
        .stat-box .s-value {
            font-size: 11px;
            font-weight: 900;
        }
        .bg-1 { background: #520C6B; }
        .bg-2 { background: #7c3aed; }
        .bg-3 { background: #0ea5e9; }
        .bg-4 { background: #10b981; }

        /* ===== TERMS ===== */
        .terms-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 18px;
            margin-top: 14px;
            font-size: 7px;
            color: #64748b;
            line-height: 1.6;
        }
        .terms-title {
            font-size: 8px;
            font-weight: 900;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
        }
        .terms-box ul {
            margin: 0;
            padding-left: 12px;
        }
        .terms-box li {
            margin-bottom: 2px;
        }

        /* ===== FOOTER ===== */
        .page-footer {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #94a3b8;
            text-align: center;
            padding: 12px 30px;
            font-size: 7px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .footer-brand {
            color: #fff;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        /* ===== DASHED DIVIDER ===== */
        .tear-line {
            border: none;
            border-top: 2px dashed #cbd5e1;
            margin: 14px 35px 0;
        }
    </style>
</head>
<body>

    <!-- ========== EVENT BANNER ========== -->
    <div class="event-banner">
        @if($eventImage)
            <img src="{{ $eventImage }}" alt="Event Banner">
        @endif
        <div class="banner-overlay"></div>
        <div class="banner-badge">{{ $booking->event->category->name ?? 'Event' }}</div>
        <div class="banner-logo">TICKET KINUN</div>
    </div>

    <!-- ========== TITLE SECTION ========== -->
    <div class="title-section">
        <h1>{{ $booking->event->title }}</h1>
        <p class="title-meta">{{ $booking->event->category->name ?? 'Event' }} &bull; Official Admission Pass &bull; {{ $booking->event->date->format('F d, Y') }}</p>
    </div>

    <!-- ========== STATUS BAR ========== -->
    <div class="status-bar">
        <span class="check">&#10003;</span> Booking Confirmed &mdash; Order #{{ $booking->booking_id }}
        &nbsp;&nbsp;|&nbsp;&nbsp; Booked on {{ $booking->created_at->format('M d, Y \a\t h:i A') }}
    </div>

    <!-- ========== MAIN DETAILS ========== -->
    <div class="main-content">
        <table class="info-table">
            <tr>
                <!-- Column 1: Event Details -->
                <td style="width: 32%; padding-right: 18px;">
                    <p class="section-heading">Event Details</p>

                    <div class="info-field">
                        <span class="info-label">Event Name</span>
                        <span class="info-value">{{ $booking->event->title }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-label">Venue / Location</span>
                        <span class="info-value">{{ $booking->event->venue_name ?? $booking->event->location }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-label">Event Date</span>
                        <span class="info-value">{{ $booking->event->date->format('l, F d, Y') }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-label">Category</span>
                        <span class="info-value-accent">{{ $booking->event->category->name ?? 'General' }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-label">Ticket Type</span>
                        <span class="info-value">
                            @foreach($booking->attendees->groupBy('ticket_type_id') as $tier)
                                {{ $tier->count() }}&times; {{ $tier->first()->ticketType->name ?? 'Standard' }}@if(!$loop->last), @endif
                            @endforeach
                        </span>
                    </div>
                </td>

                <!-- Column 2: Registration Info -->
                <td style="width: 34%; padding-right: 18px;">
                    <p class="section-heading">Registration Info</p>
                    @php
                        $formData = $booking->form_data ?? [];
                        $formFields = $booking->event->formFields ?? collect();
                        $displayCount = 0;
                    @endphp

                    @foreach($formFields as $field)
                        @if(isset($formData[$field->id]) && !empty($formData[$field->id]) && $displayCount < 6)
                            <div class="info-field">
                                <span class="info-label">{{ $field->label }}</span>
                                <span class="info-value">
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
                        <div class="info-field">
                            <span class="info-label">Name</span>
                            <span class="info-value">{{ $booking->user->name }}</span>
                        </div>
                        <div class="info-field">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $booking->user->email }}</span>
                        </div>
                    @endif

                    <div class="info-field">
                        <span class="info-label">Booking Reference</span>
                        <span class="info-value-accent">{{ $booking->booking_id }}</span>
                    </div>
                    <div class="info-field">
                        <span class="info-label">Booking Date</span>
                        <span class="info-value">{{ $booking->created_at->format('M d, Y') }}</span>
                    </div>
                </td>

                <!-- Column 3: QR Code -->
                <td style="width: 34%;">
                    <p class="section-heading" style="text-align: center;">Scan to Verify</p>
                    <div class="qr-container">
                        @if($qrcode)
                            <img src="{{ $qrcode }}" alt="QR Code">
                        @else
                            <p style="padding: 40px 0; font-size: 10px; color: #94a3b8;">QR Unavailable</p>
                        @endif
                        <p class="qr-ticket-number">{{ $booking->booking_id }}</p>
                        <p class="qr-scan-text">Present this QR code at entry gate</p>
                    </div>
                </td>
            </tr>
        </table>

        <!-- ========== ATTENDEE LIST ========== -->
        @if($booking->attendees->count() > 0)
            <p class="attendee-heading">Attendee Details ({{ $booking->attendees->count() }} {{ $booking->attendees->count() === 1 ? 'Person' : 'People' }})</p>
            <table class="attendee-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Name</th>
                        <th style="width: 20%;">Mobile</th>
                        <th style="width: 20%;">Ticket Type</th>
                        <th style="width: 30%;">Ticket Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->attendees as $idx => $attendee)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td style="font-weight: 800; color: #0f172a;">{{ $attendee->name }}</td>
                            <td>{{ $attendee->mobile }}</td>
                            <td>{{ $attendee->ticketType->name ?? 'Standard' }}</td>
                            <td class="ticket-num-cell">{{ $attendee->ticket_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- ========== STATS ========== -->
        <table class="stats-table">
            <tr>
                <td class="stat-box bg-1">
                    <span class="s-label">Total Paid</span>
                    <span class="s-value">&#2547; {{ number_format($booking->total_amount, 2) }}</span>
                </td>
                <td class="stat-box bg-2">
                    <span class="s-label">Tickets</span>
                    <span class="s-value">{{ $booking->attendees->count() }} {{ $booking->attendees->count() === 1 ? 'Pass' : 'Passes' }}</span>
                </td>
                <td class="stat-box bg-3">
                    <span class="s-label">Event Date</span>
                    <span class="s-value">{{ $booking->event->date->format('M d, Y') }}</span>
                </td>
                <td class="stat-box bg-4">
                    <span class="s-label">Status</span>
                    <span class="s-value">CONFIRMED</span>
                </td>
            </tr>
        </table>

        <!-- Tear Line -->
        <hr class="tear-line" style="margin-left: 0; margin-right: 0;">

        <!-- ========== TERMS ========== -->
        <div class="terms-box">
            <p class="terms-title">Terms &amp; Conditions</p>
            <ul>
                <li>Please arrive at least 30 minutes before the event start time for smooth check-in.</li>
                <li>A printed or digital copy of this ticket must be presented at the registration desk.</li>
                <li>Each QR code is unique and valid for a single scan only. Do not share or duplicate this ticket.</li>
                <li>The organizer reserves the right of admission based on venue capacity and security requirements.</li>
                <li>Tickets are non-refundable unless the event is cancelled by the organizer.</li>
            </ul>
        </div>
    </div>

    <!-- ========== FOOTER ========== -->
    <div class="page-footer">
        <p class="footer-brand">Ticket Kinun</p>
        <p>Your Trusted Event Ticketing Platform &bull; www.ticketkinun.com &bull; Generated on {{ now()->format('M d, Y \a\t h:i A') }}</p>
    </div>

</body>
</html>
