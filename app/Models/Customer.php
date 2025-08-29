<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
  
    function state(){
        return $this->hasOne('App\Models\State','id','state');
    }
  
    function city(){
        return $this->hasOne('App\Models\City','id','city');   
    }
    
    function customer_state(){
        return $this->hasOne('App\Models\State','id','state');
    }
  
    function customer_city(){
        return $this->hasOne('App\Models\City','id','city');   
    }

    function type(){
        return $this->hasOne('App\Models\CustomerTypeMaster','id','customer_type');   
    }
    
    public function VendorAllocation(){
        return $this->hasMany('App\Models\VendorAllocation','vendor_id','id');
    }
}
