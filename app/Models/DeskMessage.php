<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
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
            'chairman' => 'Chairman',
            default => ucfirst($this->role),
        };
    }
}
