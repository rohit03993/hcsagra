<?php

namespace App\Enums;

enum PostType: string
{
    case Announcement = 'announcement';
    case Achievement = 'achievement';
    case Event = 'event';

    public function label(): string
    {
        return match ($this) {
            self::Announcement => 'Announcement',
            self::Achievement => 'Achievement',
            self::Event => 'Event',
        };
    }
}
