<?php

namespace App\Filament\Resources\DeviceChangePartnerResource\Pages;

use App\Filament\Resources\DeviceChangePartnerResource;
use Filament\Actions;
use Filament\Actions\Modal\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Models\DeviceChangePartner;

class EditDeviceChangePartner extends EditRecord
{
    protected static string $resource = DeviceChangePartnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('pdf')
                ->icon('heroicon-s-document-arrow-down')
                ->color('info')
                ->url(fn (DeviceChangePartner $records) => route('download_pdf', $records))
                ->openUrlInNewTab(),
        ];
    }
}
