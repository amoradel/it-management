<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relacion uno a muchos (inversa)
    public function department(){
        return $this->belongsTo('App\Models\Department');
    }

    // Relacion muchos a muchos
    public function devices(){
        return $this->belongsToMany('App\Models\Device', 'device_partner')->withTimestamps();
    }
}
