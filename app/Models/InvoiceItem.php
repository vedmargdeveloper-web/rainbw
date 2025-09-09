<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // Accessor to calculate profit
    public function getProfitAttribute()
    {
        if ($this->item && $this->item->profit_margin) {
            return ($this->gross_amount * $this->item->profit_margin) / 100;
        }
        return 0;
    }
}
