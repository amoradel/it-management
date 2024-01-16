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
            self::Computer => [self::Computer->value => __('Computer')],
            self::Printer => [self::Printer->value => __('Printer')],
            self::Monitor => [self::Monitor->value => __('Monitor')],
            self::Camera => [self::Camera->value => __('Camera')],
            self::Dvr => [self::Dvr->value => __('DVR')],
            self::Network => [self::Network->value => __('Network')],
            self::AccessControl => [self::AccessControl->value => __('Access Control')],
            self::Alarm => [self::Alarm->value => __('Alarm')],
            self::Pos => [self::Pos->value => __('POS')],
            self::Voip => [self::Voip->value => __('VoIP')],
            self::Others => [self::Others->value => __('Others')],
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
