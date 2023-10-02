<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceChange extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relaciones muchos a muchos
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
    // Relaciones muchos a muchos

    // Relaciones uno a muchos (inversa)
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
    // Fin Relaciones uno a muchos (inversa)

    // Relacion de las piezas/equipos (device_changes) con device_change_partner para el relation manager
    public function deviceChangePartners()
    {
        return $this->belongsToMany(DeviceChangePartner::class, 'device_change_partner_details');
    }
}
