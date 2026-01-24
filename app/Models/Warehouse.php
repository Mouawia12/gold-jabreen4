<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_id',
        'type',
        'karat_id',
        'category_id',
        'enter_weight',
        'out_weight',
        'bill_id',
        'date',
        'user_id',
    ];
}
