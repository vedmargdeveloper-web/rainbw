<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    use HasFactory;
    protected  $table = 'pitches';
    protected $guarded = [];

    public function quotation(){
        return $this->hasOne('App\Models\Quotation','id','quotation_id');
    }
    public function inquiry(){
        return $this->hasOne('App\Models\Inquiry','id','quotation_id');
    }
}
