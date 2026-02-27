<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSupport extends Model
{
    protected $fillable = [
        'badge_text',
        'email',
        'phone',
        'address',
        'card_title',
        'card_description',
        'image',
        'call_url',
        'whatsapp_url',
    ];
}
