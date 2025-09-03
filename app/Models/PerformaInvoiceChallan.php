<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformaInvoiceChallan extends Model
{
    protected $table = 'performa_invoice_challans';

    protected $fillable = [
        'user_id',
        'challan_type',
        'ref_pi_no',
        'gst_id',
        'challan_no',
        'challan_date',
        'billing_date',
        'event_time',
        'customer_type',
        'readyness',
        'customer_id',
        'customer_details',
        'delivery_id',
        'delivery_details',
        'supply_id',
        'start_date',
        'end_date',
        'supply_details',
        'net_amount',
        'net_discount',
        'total_tax',
        'total_amount',
        'dayormonth',
        'compition',
        'gst_details',
        'amount_in_words',
        'original_challan_id'
    ];

    // Relationships
    public function challanItems()
    {
        return $this->hasMany(PerformaInvoiceChallanItem::class, 'challan_id');
    }

     public function customerType(){
        return $this->hasOne('App\Models\CustomerTypeMaster','id','customer_type');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function occasion()
    {
        return $this->belongsTo(Occasion::class, 'occasion_id', 'id');
    }

    
}
