<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class MediaUrl
{
    public static function public(?string $path, bool $versioned = false): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return null;
        }

        $url = $disk->url($path);

        if ($versioned) {
            $url .= (str_contains($url, '?') ? '&' : '?').'v='.$disk->lastModified($path);
        }

        return $url;
    }
}
