<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DefaultApp: string implements HasLabel
{
    case IVMS4200 = 'IVMS-4200';
    case CMS3 = 'CMS3.0';
    case VIMonitorPlus = 'VI MonitorPlus';
    case BioAdmin = 'BioAdmin';
    case Others = 'others';

    public function getLabel(): ?string
    {
        return $this->name;

    }

    public function getOption()
    {
        return match ($this) {
            self::IVMS4200 => [self::IVMS4200->value => self::IVMS4200->getLabel()],
            self::CMS3 => [self::CMS3->value => self::CMS3->getLabel()],
            self::VIMonitorPlus => [self::VIMonitorPlus->value => self::VIMonitorPlus->getLabel()],
            self::BioAdmin => [self::BioAdmin->value => self::BioAdmin->getLabel()],
            self::Others => [self::Others->value => self::Others->getLabel()],
            default => [__('Unknown') => __('Unknown')],
        };
    }

    public static function getAllOnString(): string
    {
        $cases = array_map(fn ($case) => $case->value, self::cases());

        $cases = implode(',', $cases);

        return $cases;
    }
}
