<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallanTypeMaster extends Model
{
    use HasFactory;
    protected $table = 'challan_type_master';

    protected $fillable = [
        'id',
        'type_name',
    ];
}
