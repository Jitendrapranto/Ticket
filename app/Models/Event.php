<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'organizer', 'title', 'slug', 'image', 'date', 'registration_deadline', 'location', 'venue_name', 'price', 'description', 'language', 'age_limit', 'duration', 'you_should_know', 'terms_conditions', 'artists', 'status', 'sort_order', 'is_featured'
    ];

    protected $casts = [
        'date' => 'datetime',
        'registration_deadline' => 'datetime',
        'price' => 'decimal:2',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
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
}
