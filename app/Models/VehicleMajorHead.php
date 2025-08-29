<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMajorHead extends Model
{
    use HasFactory;
    protected  $table = 'vehicle_major_heads';
    protected $guarded = [];

    public function parent(){
        return $this->hasOne('App\Models\VehicleMajorHead','major','id');
    }

}
