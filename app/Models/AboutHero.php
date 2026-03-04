<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutHero extends Model
{
    protected $table = 'about_hero_sections';

    protected $fillable = [
        'badge_text',
        'title_main',
        'title_accent',
        'subtitle',
    ];
}
