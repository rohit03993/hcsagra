<?php

namespace App\Filament\Resources\HeroSlideResource\Pages;

use App\Filament\Resources\HeroSlideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeroSlides extends ListRecords
{
    protected static string $resource = HeroSlideResource::class;

    public function getSubheading(): ?string
    {
        return 'One slide = one homepage banner. Use “New slide” for each photo — editing one slide does not change the others.';
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
