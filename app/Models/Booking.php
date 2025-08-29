<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = "bookings";
    protected $guarded = [];

    public function customerType(){
        return $this->hasOne('App\Models\CustomerTypeMaster','id','customer_type');
    }
    public function bookingItem(){
        return $this->hasMany('App\Models\BookingsItem','invoice_id','id');
    }
    public function inquiry(){
        return $this->hasOne('App\Models\Inquiry','id','enquire_id');
    }
    
    public function pitch(){
        return $this->hasMany('App\Models\Pitch','quotation_id','id');
    }

    public function leadstatus(){
        return $this->hasOne('App\Models\LeadStatusLog','inquires_id','enquire_id')->latest();
    }
    public function quotaiton(){
        return $this->hasOne('App\Models\Quotation','enquire_id','enquire_id')->latest();
    }
    
   
    
}
