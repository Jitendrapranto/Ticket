<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutAdvantage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'card_bg_color',
        'icon_bg_color',
        'title_color',
        'desc_color',
        'border_class',
        'sort_order',
    ];
}
