<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAttendee extends Model
{
    protected $fillable = [
        'booking_id',
        'ticket_type_id',
        'name',
        'mobile'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
