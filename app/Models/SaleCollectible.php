<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Model;

class SaleCollectible extends Model
{
    protected $table = "sale_collectibles";
    protected $fillable = [
        'id',
        'branch_id',
        'bill_number',
        'date',
        'client_id',
        'client_tax_number',
        'total_money', 
        'paid_money',
        'remain_money',
        'paid_gold',
        'remain_gold',
        'discount',
        'tax',
        'net_money',
        'returned_bill_id',
        'bill_client_name',
        'pos',
        'notes',
        'user_id' 

    ];

    public function branch(){
        return $this -> belongsTo(\App\Models\Branch::class ,'branch_id' );
    }
}
