<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'event_code', 'category_id', 'user_id', 'organizer', 'title', 'slug', 'image', 'date', 'registration_deadline', 'location', 'venue_name', 'price', 'description', 'language', 'age_limit', 'duration', 'you_should_know', 'terms_conditions', 'artists', 'status', 'is_approved', 'sort_order', 'is_featured'
    ];

    protected $casts = [
        'date' => 'datetime',
        'registration_deadline' => 'datetime',
        'price' => 'decimal:2',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'artists' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            if (!$event->slug) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function formFields()
    {
        return $this->hasMany(EventFormField::class)->orderBy('sort_order');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute()
    {
        $image = $this->attributes['image'] ?? null;
        if (!$image) {
            return asset('images/placeholder.png'); // Fallback placeholder
        }

        $image = trim($image);
        if (str_starts_with($image, 'http')) {
            return $image;
        }

        return asset('storage/' . $image);
    }

    /**
     * Get total available tickets across all ticket types.
     */
    public function getTotalAvailableTicketsAttribute()
    {
        return $this->ticketTypes->sum('quantity');
    }

    /**
     * Check if the event is sold out (all ticket types have 0 quantity).
     */
    public function getIsSoldOutAttribute()
    {
        // If no ticket types exist, not sold out
        if ($this->ticketTypes->isEmpty()) {
            return false;
        }
        return $this->total_available_tickets <= 0;
    }
}
