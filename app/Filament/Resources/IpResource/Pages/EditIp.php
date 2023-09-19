<?php

namespace App\Filament\Resources\IpResource\Pages;

use App\Filament\Resources\IpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIp extends EditRecord
{
    protected static string $resource = IpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
