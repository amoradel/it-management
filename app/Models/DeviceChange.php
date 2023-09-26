<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Relacion uno a muchos (inversa)
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(Device_model::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
