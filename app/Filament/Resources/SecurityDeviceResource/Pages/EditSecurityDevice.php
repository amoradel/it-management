<?php

namespace App\Filament\Resources\SecurityDeviceResource\Pages;

use App\Filament\Resources\SecurityDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSecurityDevice extends EditRecord
{
    protected static string $resource = SecurityDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
