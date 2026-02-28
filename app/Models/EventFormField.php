<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFormField extends Model
{
    protected $fillable = ['event_id', 'label', 'type', 'options', 'is_required', 'is_default', 'sort_order'];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
