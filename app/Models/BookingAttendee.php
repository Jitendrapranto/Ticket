<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAttendee extends Model
{
    protected $fillable = [
        'booking_id',
        'ticket_number',
        'ticket_type_id',
        'name',
        'mobile',
        'is_scanned',
        'scanned_at',
        'scanner_id'
    ];

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanner_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
