<?php

namespace App\Support;

class Youtube
{
    public static function idFromUrl(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public static function thumbnailUrl(?string $videoId, string $quality = 'hqdefault'): ?string
    {
        if (blank($videoId)) {
            return null;
        }

        return "https://i.ytimg.com/vi/{$videoId}/{$quality}.jpg";
    }

    public static function embedUrl(?string $videoId, bool $autoplay = true): ?string
    {
        if (blank($videoId)) {
            return null;
        }

        $params = http_build_query([
            'autoplay' => $autoplay ? 1 : 0,
            'rel' => 0,
            'modestbranding' => 1,
        ]);

        return "https://www.youtube-nocookie.com/embed/{$videoId}?{$params}";
    }
}
