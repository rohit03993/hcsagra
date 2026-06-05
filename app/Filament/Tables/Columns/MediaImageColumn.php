<?php

namespace App\Filament\Tables\Columns;

use App\Support\MediaUrl;
use Filament\Tables\Columns\ImageColumn;

class MediaImageColumn extends ImageColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->checkFileExistence(false);
    }

    public function getImageUrl(?string $state = null): ?string
    {
        if (is_array($state)) {
            $state = $state[0] ?? null;
        }

        if (blank($state)) {
            return $this->getDefaultImageUrl();
        }

        return MediaUrl::public($state) ?? parent::getImageUrl($state);
    }
}
