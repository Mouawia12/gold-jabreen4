<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterWorkDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'bill_id',
        'karat_id',
        'category_id',
        'weight',
        'weight21',
        'made_money',
        'made_value',
        'net_weight',
        'tax',
        'net_money',
        'returned_weight'
    ];
}
