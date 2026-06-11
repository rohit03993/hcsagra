<?php

namespace App\Support;

use App\Filament\Support\ManagedImageUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageProcessor
{
    public static function normalizePath(mixed $path): ?string
    {
        if (is_array($path)) {
            $path = $path[0] ?? null;
        }

        if (! is_string($path) || blank($path)) {
            return null;
        }

        return $path;
    }

    /**
     * Resize with center crop (cover) — never squash/stretch. Skips upscaling small files.
     */
    public static function process(?string $path, string $preset): ?string
    {
        $path = self::normalizePath($path);

        if ($path === null || ! extension_loaded('gd')) {
            return $path;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, ['svg', 'ico'], true)) {
            return $path;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return $path;
        }

        if ($disk->size($path) < 200) {
            return $path;
        }

        $config = ManagedImageUpload::PRESETS[$preset] ?? null;
        if ($config === null) {
            return $path;
        }

        $targetW = $config['w'];
        $targetH = $config['h'];
        $fullPath = $disk->path($path);

        $src = self::loadImage($fullPath);
        if ($src === null) {
            return $path;
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);

        if ($srcW < 20 || $srcH < 20) {
            imagedestroy($src);

            return $path;
        }

        $srcRatio = $srcW / $srcH;
        $targetRatio = $targetW / $targetH;
        $ratioMatches = abs($srcRatio - $targetRatio) < 0.03;

        // Keep the admin crop when already within target size.
        if ($srcW <= $targetW && $srcH <= $targetH) {
            imagedestroy($src);

            return $path;
        }

        // Same aspect ratio as preset: scale down only — do not center-crop again.
        $dst = $ratioMatches
            ? self::resizeDown($src, $srcW, $srcH, $targetW, $targetH)
            : self::resizeCover($src, $srcW, $srcH, $targetW, $targetH);
        imagedestroy($src);

        $usePng = str_contains($extension, 'png') || str_contains(mime_content_type($fullPath) ?: '', 'png');
        $directory = trim(dirname($path), '.\\/');
        $newPath = ($directory !== '' ? $directory.'/' : '').Str::uuid()->toString().($usePng ? '.png' : '.jpg');

        $saved = $usePng
            ? self::savePng($dst, $disk->path($newPath))
            : self::saveJpeg($dst, $disk->path($newPath));

        imagedestroy($dst);

        if (! $saved) {
            return $path;
        }

        $info = @getimagesize($disk->path($newPath));
        if ($info === false || $info[0] < 80 || $info[1] < 80) {
            $disk->delete($newPath);

            return $path;
        }

        if ($newPath !== $path) {
            $disk->delete($path);
        }

        return $newPath;
    }

    /**
     * Scale down when aspect ratio already matches (preserves Filament crop).
     *
     * @param \GdImage|resource $src
     * @return \GdImage|resource
     */
    private static function resizeDown($src, int $srcW, int $srcH, int $targetW, int $targetH)
    {
        $scale = min($targetW / $srcW, $targetH / $srcH, 1);
        $newW = max(1, (int) round($srcW * $scale));
        $newH = max(1, (int) round($srcH * $scale));

        $dst = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);

        return $dst;
    }

    /**
     * @param \GdImage|resource $src
     * @return \GdImage|resource
     */
    private static function resizeCover($src, int $srcW, int $srcH, int $targetW, int $targetH)
    {
        $scale = max($targetW / $srcW, $targetH / $srcH);
        $scaledW = max($targetW, (int) round($srcW * $scale));
        $scaledH = max($targetH, (int) round($srcH * $scale));

        $scaled = imagecreatetruecolor($scaledW, $scaledH);
        imagecopyresampled($scaled, $src, 0, 0, 0, 0, $scaledW, $scaledH, $srcW, $srcH);

        $dst = imagecreatetruecolor($targetW, $targetH);
        $srcX = (int) max(0, floor(($scaledW - $targetW) / 2));
        $srcY = (int) max(0, floor(($scaledH - $targetH) / 2));
        imagecopyresampled($dst, $scaled, 0, 0, $srcX, $srcY, $targetW, $targetH, $targetW, $targetH);
        imagedestroy($scaled);

        return $dst;
    }

    private static function saveJpeg(\GdImage $image, string $fullPath): bool
    {
        return imagejpeg($image, $fullPath, 88);
    }

    private static function savePng(\GdImage $image, string $fullPath): bool
    {
        imagealphablending($image, false);
        imagesavealpha($image, true);

        return imagepng($image, $fullPath, 6);
    }

    /**
     * @return \GdImage|resource|null
     */
    private static function loadImage(string $fullPath)
    {
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $mime = mime_content_type($fullPath) ?: '';

        return match (true) {
            $extension === 'png' || str_contains($mime, 'png') => @imagecreatefrompng($fullPath),
            $extension === 'webp' || str_contains($mime, 'webp') => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($fullPath) : null,
            $extension === 'gif' || str_contains($mime, 'gif') => @imagecreatefromgif($fullPath),
            default => @imagecreatefromjpeg($fullPath),
        };
    }
}
