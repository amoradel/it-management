<?php

namespace App\Filament\Resources\POSResource\Pages;

use App\Filament\Resources\POSResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPOS extends EditRecord
{
    protected static string $resource = POSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
