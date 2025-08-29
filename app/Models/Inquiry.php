<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inquiry extends Model
{
    use HasFactory; 
    protected $table = 'inquires';
    protected  $guarded = [];

    public function leadstatus(){
        return $this->hasOne('App\Models\LeadStatusLog','inquires_id','id')->latest();
    }
    public function inquiryItems(){
        return $this->hasMany('App\Models\EnquireItem','inquiry_id','id');
    }
    
    public function customer(){
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }

    public function quotation(){
        return $this->hasOne('App\Models\Quotation','enquire_id','id');
    }
    public function address(){
        return $this->hasOne('App\Models\Address','id','delivery_id');
    }
    
    public function occassion(){
        return $this->hasOne('App\Models\Occasion','id','occasion_id')->latest();
    }
   
}
