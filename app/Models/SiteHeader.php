<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteHeader extends Model
{
    protected $fillable = [
        'logo_path',
        'search_placeholder',
        'login_text',
        'signup_text',
        'nav_links',
    ];

    protected $casts = [
        'nav_links' => 'array',
    ];
}
