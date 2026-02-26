<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventHero extends Model
{
    protected $fillable = [
        'badge_text',
        'title',
        'subtitle',
        'search_placeholder',
    ];
}
