<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class SaleCollectibleDetails extends Model
{
    protected $table = "sale_collectibles_details";
    protected $fillable = [
        'id',
        'bill_id',
        'item_id',
        'karat_id',
        'weight',
        'gram_price',
        'gram_manufacture',
        'gram_tax',
        'net_money',
        'returned'
    ];



}
