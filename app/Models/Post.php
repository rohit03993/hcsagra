<?php

namespace App\Models;

use App\Enums\PostType;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use Publishable;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'excerpt',
        'body',
        'image_path',
        'pdf_path',
        'external_url',
        'published_at',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'type' => PostType::class,
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublishedPosts(Builder $query): Builder
    {
        return $query->published()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeOfType(Builder $query, PostType $type): Builder
    {
        return $query->where('type', $type->value);
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
