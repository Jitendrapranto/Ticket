<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteFooter extends Model
{
    protected $fillable = [
        'logo_path',
        'description',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'explorer_title',
        'explorer_links',
        'collections_title',
        'collections_items',
        'contact_title',
        'contact_email',
        'contact_phone',
        'contact_address',
        'copyright_text',
        'privacy_url',
        'terms_url',
        'cookies_url',
    ];

    protected $casts = [
        'explorer_links'   => 'array',
        'collections_items' => 'array',
    ];
}
