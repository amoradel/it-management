<?php

namespace App\Filament\Resources\IpResource\Pages;

use App\Filament\Resources\IpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIps extends ListRecords
{
    protected static string $resource = IpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
