<?php

namespace App\Filament\Resources\DeviceChangeResource\Pages;

use App\Filament\Resources\DeviceChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceChanges extends ListRecords
{
    protected static string $resource = DeviceChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
