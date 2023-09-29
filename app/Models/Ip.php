<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ip extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relacion uno a uno
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }
}
