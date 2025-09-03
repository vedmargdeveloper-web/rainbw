<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformaInvoiceChallanItem extends Model
{
    protected $table = 'performa_invoice_challan_items';

    protected $fillable = [
        'challan_id',
        'item_id',
        'sac_code',
        'hsn_code',
        'description',
        'from_date',
        'to_date',
        'item',
        'rate',
        'quantity',
        'days',
        'month',
        'gross_amount',
        'discount',
        'cgst',
        'igst',
        'sgst',
        'tax_amount',
        'total_amount'
    ];

    // Relationships
    public function challan()
    {
        return $this->belongsTo(PerformaInvoiceChallan::class, 'challan_id');
    }

    public function itemData()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
