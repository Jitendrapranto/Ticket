<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionOverride extends Model
{
    protected $fillable = [
        'overridable_id',
        'overridable_type',
        'revenue_model',
        'percentage',
        'fixed_amount',
        'is_active',
    ];

    public function overridable()
    {
        return $this->morphTo();
    }
}
