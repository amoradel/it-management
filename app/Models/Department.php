<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relacion uno a muchos
    public function partners(){
        return $this->hasMany('App\Models\Partner');
    }

    public function devices(){
        return $this->hasMany('App\Models\Device');
    }
}
