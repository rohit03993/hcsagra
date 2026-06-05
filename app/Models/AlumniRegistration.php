<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniRegistration extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'batch_year',
        'current_occupation',
        'message',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function markAsRead(): void
    {
        if ($this->read_at === null) {
            $this->update(['read_at' => now()]);
        }
    }
}
