<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Device extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $guarded = [];

    // Funcion para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'ubication',
                'brand_id',
                'model_id',
                'type_id',
                'department_id',
                'description',
                'storage',
                'ram_memory',
                'processor',
                'asset_number',
                'serial_number',
                'any_desk',
                'office_version',
                'windows_version',
                'dvr_program',
                'observation',
                'condition',
                'entry_date',
                'status'
            ]);
    }

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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    // Fin Relaciones uno a muchos (inversa)

    // Relaciones muchos a muchos
    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'device_partner');
    }

    public function device_changes()
    {
        return $this->belongsToMany(DeviceChange::class, 'device_change_partners');
    }
    // Fin Relaciones muchos a muchos

    // Relaciones uno a uno
    public function ip()
    {
        return $this->hasOne('App\Models\Ip');
    }
    // Fin Relaciones uno a uno

    // Relacion de los dispositivos (devices) con device_change_partner para el relation manager
    public function deviceChangePartners()
    {
        return $this->belongsToMany(DeviceChangePartner::class, 'device_change_partner_details');
    }

    // Metodo que genera el log del Campo Historico Automaticamente
    protected static function booted()
    {
        static::updating(function ($device) {
            if ($device->isDirty('ubication')) {
                $device->historic = $device->getOriginal('ubication');
            }
        });
    }
}
