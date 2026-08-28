<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SalesProfileSection extends Model
{
    protected $fillable = [
        'type',
        'layout',
        'eyebrow',
        'title',
        'body',
        'media_path',
        'media_url',
        'thumbnail_path',
        'thumbnail_url',
        'button_label',
        'button_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function salesProfile(): BelongsTo
    {
        return $this->belongsTo(SalesProfile::class);
    }

    public function mediaUrl(): ?string
    {
        if ($this->media_path) {
            return $this->salesProfile->mediaUrl($this->media_path);
        }

        return $this->media_url;
    }

    public function videoEmbedUrl(): ?string
    {
        if (! $this->media_url) {
            return null;
        }

        $parts = parse_url($this->media_url);
        $host = Str::lower(preg_replace('/^www\./', '', $parts['host'] ?? ''));
        $path = trim($parts['path'] ?? '', '/');
        if ($videoId = $this->youtubeVideoId()) {
            return "https://www.youtube-nocookie.com/embed/{$videoId}";
        }

        if ($host === 'vimeo.com' && preg_match('/^\d+$/', $path)) {
            return "https://player.vimeo.com/video/{$path}";
        }

        if (Str::endsWith($host, 'tiktok.com')
            && preg_match('#(?:^|/)@[^/]+/video/(\d+)(?:/|$)#', $path, $matches)) {
            return "https://www.tiktok.com/player/v1/{$matches[1]}";
        }

        return null;
    }

    public function videoThumbnailUrl(): ?string
    {
        if ($this->thumbnail_path) {
            return $this->salesProfile->mediaUrl($this->thumbnail_path);
        }

        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        if ($videoId = $this->youtubeVideoId()) {
            return "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }

    public function hasDirectVideo(): bool
    {
        if ($this->media_path) {
            return true;
        }

        $path = parse_url((string) $this->media_url, PHP_URL_PATH);

        return (bool) preg_match('/\.(mp4|webm|ogg)$/i', (string) $path);
    }

    private function youtubeVideoId(): ?string
    {
        if (! $this->media_url) {
            return null;
        }

        $parts = parse_url($this->media_url);
        $host = Str::lower(preg_replace('/^www\./', '', $parts['host'] ?? ''));
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if ($host === 'youtu.be') {
            $videoId = Str::before($path, '/');
        } elseif (in_array($host, ['youtube.com', 'm.youtube.com'], true)) {
            if ($path === 'watch') {
                parse_str($parts['query'] ?? '', $query);
                $videoId = $query['v'] ?? null;
            } elseif (Str::startsWith($path, ['embed/', 'shorts/'])) {
                $videoId = Str::after($path, '/');
            }
        }

        return $videoId && preg_match('/^[A-Za-z0-9_-]{6,20}$/', $videoId)
            ? $videoId
            : null;
    }
}
