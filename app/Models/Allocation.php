<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function allocationVendor(){
        return $this->hasMany('App\Models\VendorAllocation','allocation_id','id');
    } 

    public function booking(){
        return $this->hasOne('App\Models\Booking','id','bookings_table_id');
    }
}
