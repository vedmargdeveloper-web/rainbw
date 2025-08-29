<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsItem extends Model
{
    use HasFactory;
    protected $table = 'bookings_items';
    protected $guarded = [];

    public function item(){
        return $this->hasMany('App\Models\Item','id','item_id');
    }
    public function vechicleGenration(){
        return $this->hasMany('App\Models\VechicleIDGenration','items_id','item_id');
    }
}
