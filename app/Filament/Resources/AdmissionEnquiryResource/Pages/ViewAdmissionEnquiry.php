<?php

namespace App\Filament\Resources\AdmissionEnquiryResource\Pages;

use App\Filament\Resources\AdmissionEnquiryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAdmissionEnquiry extends ViewRecord
{
    protected static string $resource = AdmissionEnquiryResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->record->markAsRead();
    }
}
