<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMap extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'map_image',
        'google_map_url',
    ];
}
