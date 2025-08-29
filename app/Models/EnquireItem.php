<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquireItem extends Model
{
    use HasFactory; 
    protected $table = 'inquiry_items';
    protected  $guarded = [];

    public function item(){
        return $this->hasOne('App\Models\Item','id','item_id');
    }
}
