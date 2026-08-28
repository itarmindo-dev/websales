<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'hero_image',
        'footer_image',
        'phone',
        'whatsapp',
        'whatsapp_number',
        'facebook',
        'facebook_link',
        'instagram',
        'instagram_link',
        'bio',
        'tagline',
        'hero_title',
        'hero_description',
        'footer_title',
        'footer_description',
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

    public function sections(): HasMany
    {
        return $this->hasMany(SalesProfileSection::class)
            ->orderBy('sort_order')
            ->orderBy('id');
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

        if (Str::startsWith($normalizedPath, 'img/')) {
            return is_file(public_path($normalizedPath))
                ? asset($normalizedPath)
                : null;
        }

        if (Str::startsWith($normalizedPath, 'storage/')) {
            $storagePath = Str::after($normalizedPath, 'storage/');

            return Storage::disk('public')->exists($storagePath)
                ? asset($normalizedPath)
                : null;
        }

        return Storage::disk('public')->exists($normalizedPath)
            ? asset('storage/'.$normalizedPath)
            : null;
    }
}
