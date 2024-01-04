<?php

namespace App\Utilities;

class DeviceTypes
{
    public const TYPES = [
        'computer' => 'Computadora',
        'printer' => 'Impresora',
        'monitor' => 'Monitor',
        'camera' => 'Cámara',
        'dvr' => 'DVR',
        'network' => 'Dispositivo de red',
        'access control' => 'Control de acceso',
        'alarm' => 'Alarma',
        'pos' => 'POS',
        'voip' => 'VoIP',
        'others' => 'Accesorios y otros',
    ];

    public static function typesKeyOnString()
    {
        $keys = array_keys(self::TYPES);

        return implode(',', $keys);
    }

    public static function typesOnString()
    {
        return implode(',', self::TYPES);
    }
}
