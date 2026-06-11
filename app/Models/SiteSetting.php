<?php

namespace App\Models;

use App\Support\HomepageSectionHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'school_name',
        'tagline',
        'default_meta_description',
        'google_analytics_measurement_id',
        'affiliation_line',
        'about_text',
        'mission_title',
        'mission_text',
        'vision_title',
        'vision_text',
        'mission_vision_page_slug',
        'phone',
        'phone_secondary',
        'email',
        'address',
        'google_maps_embed_url',
        'whatsapp_url',
        'facebook_url',
        'instagram_url',
        'youtube_channel_url',
        'admission_url',
        'careers_url',
        'mandatory_disclosure_url',
        'fee_payment_url',
        'logo_path',
        'favicon_path',
        'show_admission_banner',
        'admission_banner_text',
        'show_news_section',
        'homepage_facilities_limit',
        'homepage_section_labels',
    ];

    protected function casts(): array
    {
        return [
            'show_admission_banner' => 'boolean',
            'show_news_section' => 'boolean',
            'homepage_facilities_limit' => 'integer',
            'homepage_section_labels' => 'array',
        ];
    }

    /** @return array{subtitle: string, title: string} */
    public function homeSectionHeading(string $section): array
    {
        $defaults = HomepageSectionHeadings::defaults()[$section] ?? [
            'subtitle' => '',
            'title' => ucfirst($section),
        ];

        $custom = is_array($this->homepage_section_labels) ? $this->homepage_section_labels : [];
        $saved = is_array($custom[$section] ?? null) ? $custom[$section] : [];

        return [
            'subtitle' => filled($saved['subtitle'] ?? null)
                ? (string) $saved['subtitle']
                : $defaults['subtitle'],
            'title' => filled($saved['title'] ?? null)
                ? (string) $saved['title']
                : $defaults['title'],
        ];
    }

    public function homepageFacilitiesLimit(): int
    {
        $limit = (int) ($this->homepage_facilities_limit ?? 6);

        return max(1, min($limit, 12));
    }

    public function showsNewsSection(): bool
    {
        return (bool) $this->show_news_section;
    }

    public static function current(): self
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::query()->firstOrCreate([], [
                'school_name' => 'Horizon School',
                'admission_banner_text' => 'Admission Open',
            ]);
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('site_settings');
    }

    /** Built-in enquiry form unless a custom URL is set. */
    public function admissionUrl(): string
    {
        return filled($this->admission_url)
            ? $this->admission_url
            : route('admission.enquiry');
    }

    public function hasCustomAdmissionUrl(): bool
    {
        return filled($this->admission_url);
    }

    public function mandatoryDisclosureUrl(): string
    {
        return filled($this->mandatory_disclosure_url)
            ? $this->mandatory_disclosure_url
            : route('mandatory-disclosure');
    }

    /** GA4 measurement ID (G-XXXXXXXX) from admin input; null when unset or invalid. */
    public function googleAnalyticsMeasurementId(): ?string
    {
        $raw = trim((string) $this->google_analytics_measurement_id);

        if ($raw === '') {
            return null;
        }

        if (preg_match('/G-[A-Z0-9]+/i', $raw, $matches)) {
            return strtoupper($matches[0]);
        }

        return null;
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}
