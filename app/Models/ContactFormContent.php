<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFormContent extends Model
{
    protected $fillable = [
        'badge_text',
        'title',
        'description',
        'button_text',
        'name_label',
        'name_placeholder',
        'email_label',
        'email_placeholder',
        'phone_label',
        'phone_placeholder',
        'subject_label',
        'message_label',
        'message_placeholder',
    ];
}
