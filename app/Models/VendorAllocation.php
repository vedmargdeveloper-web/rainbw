<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAllocation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Allocation(){
        return $this->hasOne('App\Models\Allocation','id','allocation_id');
    }

    public function vendorfetch(){
        return $this->hasOne('App\Models\Customer','id','vendor_id');
    }

    public function item(){
        return $this->hasOne('App\Models\Item','id','item_id');
    }
    // public function leadstatus(){
    //     return $this->hasOne('App\Models\LeadStatusLog','inquires_id','inquires_id');
    // }

}
