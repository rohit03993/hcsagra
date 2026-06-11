<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeskMessage extends Model
{
    use Publishable;

    protected $fillable = [
        'role',
        'name',
        'designation',
        'message',
        'photo_path',
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

    public function roleLabel(): string
    {
        return match ($this->role) {
            'principal' => 'Principal',
            'chairman' => 'Director',
            default => ucfirst($this->role),
        };
    }

    public function scopeOrderedForDisplay(Builder $query): Builder
    {
        return $query
            ->orderByRaw("CASE role WHEN 'chairman' THEN 0 WHEN 'principal' THEN 1 ELSE 2 END")
            ->ordered();
    }
}
