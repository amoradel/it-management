<?php

namespace App\Filament\Resources\IpResource\Pages;

use App\Filament\Resources\IpResource;
use App\Models\Ip;
use Filament\Actions;
use Filament\Resources\Components\Tab;
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
                    return Ip::create([
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

    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];

        $segments = getGroupedColumnValues(table: 'ips', column: 'segment');

        foreach ($segments as $segment) {
            $slug = str($segment)->slug()->toString();

            $tabs[$slug] = Tab::make($segment)
                ->badge(Ip::where('segment', $segment)->count())
                ->modifyQueryUsing(function ($query) use ($segment) {
                    return $query->where('segment', $segment);
                });
        }

        return $tabs;
    }
}
