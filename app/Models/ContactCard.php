<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCard extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'description',
        'action_text',
        'action_url',
        'bg_color',
        'theme_color',
        'title_color',
        'desc_color',
        'sort_order',
    ];
}
