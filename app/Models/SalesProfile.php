<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SalesProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mediaUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::startsWith($normalizedPath, ['img/', 'storage/'])) {
            return asset($normalizedPath);
        }

        return Storage::disk('public')->url($normalizedPath);
    }
}
