<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitWorkDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'bill_id',
        'item_id',
        'karat_id',
        'count',
        'weight',
        'gram_price',
        'gram_manufacture',
        'gram_tax',
        'net_money',
        'returned'
    ];

    public function item(){
        return $this -> belongsTo(\App\Models\Item::class ,'item_id');
    }

}
