<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DeviceType: string implements HasLabel
{
    case Computer = 'computer';
    case Printer = 'printer';
    case Monitor = 'monitor';
    case Camera = 'camera';
    case Dvr = 'dvr';
    case Network = 'network';
    case AccessControl = 'access control';
    case Alarm = 'alarm';
    case Pos = 'pos';
    case Voip = 'voip';
    case Others = 'others';

    public function getLabel(): ?string
    {
        // return $this->name;

        return match ($this) {
            self::Computer => __('Computer'),
            self::Printer => __('Printer'),
            self::Monitor => __('Monitor'),
            self::Camera => __('Camera'),
            self::Dvr => __('DVR'),
            self::Network => __('Network'),
            self::AccessControl => __('Access Control'),
            self::Alarm => __('Alarm'),
            self::Pos => __('POS'),
            self::Voip => __('VoIP'),
            self::Others => __('Others'),
            default => __('Unknown'),
        };
    }

    public function getOption()
    {
        return match ($this) {
            self::Computer => [self::Computer->value => self::Computer->getLabel()],
            self::Printer => [self::Printer->value => self::Printer->getLabel()],
            self::Monitor => [self::Monitor->value => self::Monitor->getLabel()],
            self::Camera => [self::Camera->value => self::Camera->getLabel()],
            self::Dvr => [self::Dvr->value => self::Dvr->getLabel()],
            self::Network => [self::Network->value => self::Network->getLabel()],
            self::AccessControl => [self::AccessControl->value => self::AccessControl->getLabel()],
            self::Alarm => [self::Alarm->value => self::Alarm->getLabel()],
            self::Pos => [self::Pos->value => self::Pos->getLabel()],
            self::Voip => [self::Voip->value => self::Voip->getLabel()],
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
