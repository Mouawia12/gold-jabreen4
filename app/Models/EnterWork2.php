<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterWork2 extends Model
{
    use HasFactory;
    public $connection = 'mysql2';
    public $table = 'enter_works';
    protected $fillable = [
        'id',
        'bill_number',
        'supplier_bill_number',
        'date',
        'supplier_id',
        'total_money',
        'total21_gold',
        'paid_money',
        'remain_money',
        'paid_gold',
        'remain_gold',
        'made_total',
        'discount', 
        'tax', 
        'net_money',
        'pos',
        'notes',
        'user_id',
        ];
}
