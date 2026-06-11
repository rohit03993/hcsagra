<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use Publishable;

    protected $fillable = [
        'title',
        'image_path',
        'album',
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

    public function scopeWithImage($query)
    {
        return $query->whereNotNull('image_path')->where('image_path', '!=', '');
    }
}
