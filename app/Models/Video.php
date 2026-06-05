<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use App\Support\Youtube;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Publishable;

    protected $fillable = [
        'title',
        'youtube_url',
        'youtube_id',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Video $video) {
            $video->youtube_id = Youtube::idFromUrl($video->youtube_url);
        });
    }
}
