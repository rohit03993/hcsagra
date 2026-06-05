<?php

namespace App\Support;

class Seo
{
    public static function title(?string $pageTitle, ?string $schoolName = null): string
    {
        $school = $schoolName ?? SiteSetting::current()->school_name;

        if (blank($pageTitle)) {
            return $school;
        }

        return "{$pageTitle} — {$school}";
    }

    public static function description(?string $text, ?string $fallback = null): string
    {
        $source = $text ?: $fallback ?: SiteSetting::current()->default_meta_description
            ?: SiteSetting::current()->tagline
            ?: 'Quality education for every child.';

        $plain = trim(strip_tags($source));

        return mb_strlen($plain) > 160 ? mb_substr($plain, 0, 157) . '...' : $plain;
    }
}
