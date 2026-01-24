<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimplifiedDebitDetails extends Model
{
    use HasFactory;
    protected $table = 'simplified_debit_details';
    protected $fillable = [ 
        'bill_id', 'simplified_detail_id','item_id', 'karat_id', 'weight', 'gram_price', 
        'gram_manufacture', 'gram_tax', 'net_money'
    ];
    public function item(){
        return $this -> belongsTo(\App\Models\Item::class ,'item_id');
    }
}
