<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceChangePartner extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'device_change_partner';

    // Relacion muchos a muchos
    public function device_change()
    {
        return $this->belongsTo(DeviceChange::class);

    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
