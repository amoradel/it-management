<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Models\Ip;
use App\Models\Partner;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $computers = Device::where('device_type', 'computer')->count();
        $monitors = Device::where('device_type', 'monitor')->count();
        $printers = Device::where('device_type', 'printer')->count();
        $pos = Device::where('device_type', 'pos')->count();
        $available_ips = Ip::where('disponibility', 'Disponible')->count();
        $taked_ips = Ip::where('disponibility', 'Ocupado')->count();
        $partners = Partner::where('status', 1)->count();

        return [
            // Suma Computadoras
            Stat::make('Computadoras', $computers)
                ->description('Recuento de Computadoras')
                ->icon('heroicon-o-cpu-chip')
                ->color('info')
                ->url('computers'),
            // Suma Monitores
            Stat::make('Monitores', $monitors)
                ->description('Recuento de Monitores')
                ->icon('heroicon-o-tv')
                ->color('info')
                ->url('monitors'),
            // Suma Impresoras
            Stat::make('Impresoras', $printers)
                ->description('Recuento de Impresoras')
                ->icon('heroicon-o-printer')
                ->color('info')
                ->url('printers'),
            // Suma POS
            Stat::make('POS', $pos)
                ->description('Recuento de Dispositivos POS Bancarios')
                ->icon('heroicon-o-server')
                ->color('info')
                ->url('p-o-s'),
            // Suma Ips Disponibles
            Stat::make("Ip's", $available_ips)
                ->icon('heroicon-o-wifi')
                ->description('Recuento de Ips Activas')
                ->descriptionIcon('heroicon-s-arrow-trending-up')
                // ->chart([$available_ips, $taked_ips])
                ->color('success')
                ->url('ips?tableFilters[disponibility][value]=Disponible'),
            // Suma Ips Ocupadas
            Stat::make("Ip's", $taked_ips)
                ->icon('heroicon-o-wifi')
                ->description('Recuento de Ips Ocupadas')
                ->descriptionIcon('heroicon-s-arrow-trending-down')
                ->color('danger')
                ->url('ips?tableFilters[disponibility][value]=Ocupado'),
            // Suma Personal
            Stat::make("Personal", $partners)
                ->description('Usuarios Activos')
                ->icon('heroicon-o-user-group')
                ->color('info')
                ->url('partners'),
        ];
    }
}
