<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VechicleIDGenration extends Model
{
    use HasFactory;
    protected  $table = 'vechicle_genrations';
    protected $guarded = [];

    public function  colors(){
       return  $this->hasOne('App\Models\Color','id','colors_id');
    }
    public function  item(){
       return  $this->hasOne('App\Models\Item','id','items_id');
    }
}
