<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relaciones uno a muchos
    public function partners()
    {
        return $this->hasMany('App\Models\Partner');
    }

    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }
    // Fin Relaciones uno a muchos

}
