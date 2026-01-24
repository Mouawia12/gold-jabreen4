<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class PurchaseCollectibleDetails extends Model
{
    protected $table = "purchase_collectible_details";
    protected $fillable = [
        'id',
        'bill_id',
        'karat_id',
        'item_id',
        'weight', 
        'made_money',
        'net_weight',
        'net_money',
    ];
}
