<?php

namespace App\Filament\Resources\IpResource\Pages;

use App\Filament\Resources\IpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListIps extends ListRecords
{
    protected static string $resource = IpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->icon('heroicon-o-document-arrow-up')
                ->modalWidth('md')
                ->uniqueField('ip_address')
                ->fields([
                    ImportField::make('ip_address')
                        ->translateLabel()
                        ->rules('required|max:15')
                        ->required(),
                    ImportField::make('description')
                        ->translateLabel()
                        ->rules('max:150')
                        ->required(),
                    ImportField::make('ip_type')
                        ->translateLabel()
                        ->rules('in:static,dynamic', ['The imported ip type is invalid.'])
                        ->required(),
                    ImportField::make('assignment_type')
                        ->translateLabel()
                        ->rules('max:30')
                        ->required(),
                    ImportField::make('segment')
                        ->translateLabel()
                        ->rules('required|max:40')
                        ->required(),
                    ImportField::make('status')
                        ->translateLabel()
                        ->rules('max:40')
                        ->required(),

                ])
                ->handleRecordCreation(function (array $data) {
                    return \App\Models\Ip::create([
                        'ip_address' => trim($data['ip_address']),
                        'description' => trim($data['description']) ?? '',
                        'ip_type' => trim($data['ip_type']),
                        'assignment_type' => trim($data['assignment_type']) ?? '',
                        'segment' => trim($data['segment']),
                        'status' => trim($data['status']),

                    ]);
                }),
        ];
    }
}
