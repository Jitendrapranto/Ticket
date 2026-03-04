<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCtaSection extends Model
{
    protected $fillable = [
        'heading',
        'heading_highlight',
        'description',
        'button_text',
        'button_url',
        'button_bg_color',
        'button_text_color',
        'bg_image_url',
    ];
}
