<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relacion uno a muchos (inversa)
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    // Relacion muchos a muchos
    public function devices()
    {
        return $this->belongsToMany('App\Models\Device', 'device_partner')->withTimestamps();
    }

    // Relacion muchos a muchos
    public function device_change_partner()
    {
        return $this->belongsToMany('App\Models\DeviceChange', 'device_change_partner')->withTimestamps();
    }
    
}
