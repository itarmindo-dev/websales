<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PublicUpload
{
    public static function store(UploadedFile $file, string $directory): string
    {
        return 'storage/'.$file->store($directory, 'public');
    }

    public static function delete(?string $publicPath): void
    {
        if (! $publicPath || ! str_starts_with($publicPath, 'storage/')) {
            return;
        }

        Storage::disk('public')->delete(substr($publicPath, 8));
    }

    public static function deleteMany(array $publicPaths): void
    {
        foreach ($publicPaths as $publicPath) {
            self::delete($publicPath);
        }
    }
}
