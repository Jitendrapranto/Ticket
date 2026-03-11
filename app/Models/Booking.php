<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'booking_id',
        'subtotal_amount',
        'commission_amount',
        'commission_percentage',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'payment_method_name',
        'transaction_id',
        'payment_number',
        'payment_screenshot',
        'form_data'
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendees()
    {
        return $this->hasMany(BookingAttendee::class);
    }
}
