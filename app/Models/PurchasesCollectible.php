<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasesCollectible extends Model
{
    protected $table = "purchases_collectibles";
    protected $fillable = [
        'id',
        'branch_id',
        'bill_number',
        'supplier_bill_number',
        'date',
        'supplier_id',
        'total_money', 
        'paid_money',
        'remain_money',
        'paid_gold',
        'remain_gold',
        'discount', 
        'tax', 
        'net_money',
        'pos',
        'notes',
        'user_id',
        ];
}
