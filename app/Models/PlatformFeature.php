<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'action_label',
        'card_bg',
        'icon_bg',
        'accent_color',
        'border_color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
