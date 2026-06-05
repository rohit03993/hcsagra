<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'school_name',
        'tagline',
        'default_meta_description',
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
    ];

    protected function casts(): array
    {
        return [
            'show_admission_banner' => 'boolean',
        ];
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

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}
