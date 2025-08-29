<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customerType(){
        return $this->hasOne('App\Models\CustomerTypeMaster','id','customer_type');
    }
    public function invoiceItem(){
        return $this->hasMany('App\Models\InvoiceItem','invoice_id','id');
    }
}
