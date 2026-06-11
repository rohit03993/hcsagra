<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class UploadCleanup
{
    /** @var list<string> */
    private const SAFE_PREFIXES = [
        'slides/',
        'gallery/',
        'facilities/',
        'posts/',
        'messages/',
        'pages/',
        'settings/',
    ];

    public static function deleteIfStored(?string $path): void
    {
        $path = ImageProcessor::normalizePath($path);

        if ($path === null || ! self::isDeletablePath($path)) {
            return;
        }

        $disk = Storage::disk('public');

        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    private static function isDeletablePath(string $path): bool
    {
        if (str_contains($path, '..')) {
            return false;
        }

        if (str_starts_with($path, 'images/demo/')) {
            return false;
        }

        foreach (self::SAFE_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
