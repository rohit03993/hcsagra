<?php

namespace App\Filament\Tables\Columns;

use App\Support\Youtube;
use Filament\Tables\Columns\ImageColumn;

class YoutubeThumbnailColumn extends ImageColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->checkFileExistence(false);
        $this->height(48);
        $this->width(85);
    }

    public function getImageUrl(?string $state = null): ?string
    {
        if (blank($state)) {
            return $this->getDefaultImageUrl();
        }

        return Youtube::thumbnailUrl($state) ?? parent::getImageUrl($state);
    }
}
