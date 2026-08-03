<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProfile extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'photo',
        'phone',
        'whatsapp',
        'whatsapp_number',
        'facebook',
        'facebook_link',
        'instagram',
        'instagram_link',
        'bio',
        'tagline',
        'slogan',
        'specialties',
        'documentation_photos',
    ];

    protected $casts = [
        'documentation_photos' => 'array',
    ];
}
