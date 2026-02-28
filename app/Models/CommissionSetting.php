<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionSetting extends Model
{
    protected $fillable = [
        'revenue_model',
        'default_percentage',
        'fixed_amount',
        'is_active',
    ];
}
