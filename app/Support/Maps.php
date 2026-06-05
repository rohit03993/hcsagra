<?php

namespace App\Support;

use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Http;

class Maps
{
    /**
     * Resolve Google Maps iframe src from admin embed HTML/URL or school address.
     */
    public static function embedSrc(?string $embedField, ?string $address): ?string
    {
        $embed = trim((string) $embedField);

        if ($embed !== '') {
            $src = self::fromAdminInput($embed);

            if ($src !== null) {
                return $src;
            }
        }

        return self::fromAddress($address);
    }

    private static function fromAdminInput(string $input): ?string
    {
        if (preg_match('/src=["\']([^"\']+)["\']/i', $input, $matches)) {
            return self::toEmbeddableSrc($matches[1]);
        }

        if (preg_match('#^https?://#i', $input)) {
            return self::toEmbeddableSrc($input);
        }

        return null;
    }

    private static function toEmbeddableSrc(string $url): ?string
    {
        $url = trim($url);

        if ($url === '') {
            return null;
        }

        if (self::isAlreadyEmbeddable($url)) {
            return $url;
        }

        if (! self::looksLikeGoogleMaps($url)) {
            return null;
        }

        $resolved = self::resolveGoogleMapsUrl($url);

        return self::buildEmbedFromMapsUrl($resolved);
    }

    private static function isAlreadyEmbeddable(string $url): bool
    {
        return str_contains($url, 'google.com/maps/embed')
            || (str_contains($url, 'maps.google.com/maps') && str_contains($url, 'output=embed'));
    }

    private static function looksLikeGoogleMaps(string $url): bool
    {
        return (bool) preg_match('#(google\.com/maps|maps\.google\.com|goo\.gl|maps\.app\.goo\.gl)#i', $url);
    }

    private static function resolveGoogleMapsUrl(string $url): string
    {
        if (! preg_match('#(goo\.gl|maps\.app\.goo\.gl)#i', $url)) {
            return $url;
        }

        try {
            $effectiveUrl = null;

            Http::withOptions([
                'on_stats' => function (TransferStats $stats) use (&$effectiveUrl): void {
                    $effectiveUrl = (string) $stats->getEffectiveUri();
                },
            ])
                ->timeout(10)
                ->withHeaders(['User-Agent' => 'HorizonSchoolCMS/1.0'])
                ->get($url);

            if (filled($effectiveUrl) && self::looksLikeGoogleMaps($effectiveUrl)) {
                return $effectiveUrl;
            }
        } catch (\Throwable) {
            // Fall through to wrapping the original URL.
        }

        return $url;
    }

    private static function buildEmbedFromMapsUrl(string $mapsUrl): string
    {
        if (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $mapsUrl, $coords)) {
            return sprintf(
                'https://maps.google.com/maps?q=%s,%s&hl=en&z=15&output=embed',
                $coords[1],
                $coords[2],
            );
        }

        if (preg_match('/[?&]q=([^&]+)/', $mapsUrl, $query)) {
            return 'https://maps.google.com/maps?q=' . $query[1] . '&hl=en&z=15&output=embed';
        }

        if (preg_match('#/maps/place/([^/@]+)#', $mapsUrl, $place)) {
            $name = rawurldecode(str_replace('+', ' ', $place[1]));

            return 'https://maps.google.com/maps?q=' . rawurlencode($name) . '&hl=en&z=15&output=embed';
        }

        return 'https://maps.google.com/maps?q=' . rawurlencode($mapsUrl) . '&hl=en&z=15&output=embed';
    }

    private static function fromAddress(?string $address): ?string
    {
        $address = trim((string) $address);

        if ($address === '') {
            return null;
        }

        return 'https://maps.google.com/maps?q=' . rawurlencode($address) . '&hl=en&z=15&output=embed';
    }
}
