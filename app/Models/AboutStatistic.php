<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'color',
        'value',
        'label',
        'sort_order',
    ];
}
