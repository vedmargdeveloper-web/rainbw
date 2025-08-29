<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = "quotations";
    protected $guarded = [];

    public function customerType(){
        return $this->hasOne('App\Models\CustomerTypeMaster','id','customer_type');
    }
    public function quotationItem(){
        return $this->hasMany('App\Models\QuotationsItem','invoice_id','id');
    }
    public function inquiry(){
        return $this->hasOne('App\Models\Inquiry','id','enquire_id');
    }
    public function pitch(){
        return $this->hasMany('App\Models\Pitch','quotation_id','id');
    }
    public function pitchLastest(){
        return $this->hasOne('App\Models\Pitch','quotation_id','id')->latest();
    }
    public function leadstatus(){
        return $this->hasOne('App\Models\LeadStatusLog','inquires_id','enquire_id')->latest();
    }
    public function occasion(){
        return $this->hasOne('App\Models\Occasion','id','occasion_id')->latest();
    }
  
}
