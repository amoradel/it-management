<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class DeviceChange extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relacion muchos a muchos
    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'device_change_partner')->withTimestamps();
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_change_partner')->withTimestamps();
    }

    public function device_change_partner()
    {
        return $this->belongsToMany(DeviceChangePartner::class, 'device_change_partner_details');
    }
}
