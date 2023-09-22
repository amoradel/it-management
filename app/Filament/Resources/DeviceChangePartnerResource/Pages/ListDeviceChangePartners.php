<?php

namespace App\Filament\Resources\DeviceChangePartnerResource\Pages;

use App\Filament\Resources\DeviceChangePartnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceChangePartners extends ListRecords
{
    protected static string $resource = DeviceChangePartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
