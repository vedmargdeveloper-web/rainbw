<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadHead extends Model
{
    use HasFactory;
    protected $table = "lead_heads";
    protected $guarded = [];
        function state(){
            return $this->hasOne('App\Models\State','id','state');
        }
        function city(){
            return $this->hasOne('App\Models\City','id','city');   
        }   
}
