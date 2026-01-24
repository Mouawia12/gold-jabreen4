<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatchGoldRecipts extends Model
{
    use HasFactory;
    protected $table = "catch_gold_recipts";
    protected $fillable = [
        'branch_id', 'docNumber', 'date', 'payment_type', 'from_account'
        , 'to_account', 'supplier_id', 'amount', 'gold21', 'sale_id','notes', 'user_id'
    ];
}
