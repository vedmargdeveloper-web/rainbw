<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationsItem extends Model
{
    use HasFactory;
    protected $table = 'quotations_items';
    protected $guarded = [];
}
