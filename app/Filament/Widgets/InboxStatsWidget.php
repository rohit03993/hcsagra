<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AdmissionEnquiryResource;
use App\Filament\Resources\ContactMessageResource;
use App\Models\AdmissionEnquiry;
use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InboxStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = -4;

    protected static bool $isDiscovered = true;

    protected function getStats(): array
    {
        $unreadAdmission = AdmissionEnquiry::query()->whereNull('read_at')->count();
        $unreadContact = ContactMessage::query()->whereNull('read_at')->count();

        return [
            Stat::make('Admission enquiries', (string) $unreadAdmission)
                ->description($unreadAdmission === 1 ? '1 unread' : ($unreadAdmission > 0 ? "{$unreadAdmission} unread" : 'All read'))
                ->descriptionIcon($unreadAdmission > 0 ? 'heroicon-m-inbox-arrow-down' : 'heroicon-m-check-circle')
                ->color($unreadAdmission > 0 ? 'warning' : 'success')
                ->url(AdmissionEnquiryResource::getUrl('index')),
            Stat::make('Contact messages', (string) $unreadContact)
                ->description($unreadContact === 1 ? '1 unread' : ($unreadContact > 0 ? "{$unreadContact} unread" : 'All read'))
                ->descriptionIcon($unreadContact > 0 ? 'heroicon-m-chat-bubble-left-right' : 'heroicon-m-check-circle')
                ->color($unreadContact > 0 ? 'warning' : 'success')
                ->url(ContactMessageResource::getUrl('index')),
        ];
    }
}
