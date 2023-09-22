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
        return $this->belongsToMany('App\Models\DeviceChange', 'device_change_partner');
    }

    public function device()
    {
        return $this->belongsToMany('App\Models\Device', 'device_change_partner');
    }

    public function partner()
    {
        return $this->belongsToMany('App\Models\Partner', 'device_change_partner');
    }
}
