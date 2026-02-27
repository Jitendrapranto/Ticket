<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactHero extends Model
{
    protected $fillable = [
        'badge_text',
        'title_main',
        'title_accent',
        'subtitle',
    ];
}
