<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'title_main',
        'title_highlight',
        'paragraph_1',
        'paragraph_2',
        'image',
        'card_1_icon',
        'card_1_bg_color',
        'card_1_icon_color',
        'card_1_title',
        'card_1_description',
        'card_2_icon',
        'card_2_bg_color',
        'card_2_icon_color',
        'card_2_title',
        'card_2_description',
    ];
}
