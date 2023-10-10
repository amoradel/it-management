<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Partner extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $guarded = [];

    // Relaciones uno a muchos (inversa)
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
    // Fin Relaciones uno a muchos (inversa)

    // Relaciones muchos a muchos
    public function devices()
    {
        return $this->belongsToMany('App\Models\Device', 'device_partner')->withTimestamps();
    }

    public function device_change_partner()
    {
        return $this->belongsToMany('App\Models\DeviceChange', 'device_change_partner')->withTimestamps();
    }
    // Fin Relaciones muchos a muchos

    // Funcion para genera el log de la tabla
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'department->id',
                'department->name',
                'username_network',
                'username_odoo',
                'username_AS400',
                'extension',
                'company_position',
                'status',
                'asset_number',
                'serial_number',
            ]);
    }
}
