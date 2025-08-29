<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $guarded = [];
        function state(){
            return $this->hasOne('App\Models\State','id','state');
        }
        function city(){
            return $this->hasOne('App\Models\City','id','city');   
        }   
        function istate(){
            return $this->hasOne('App\Models\State','id','state');
        }
        function icity(){
            return $this->hasOne('App\Models\City','id','city');   
        }   
}
