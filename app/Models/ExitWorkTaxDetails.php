<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;

class ExitWorkTaxDetails extends Model
{
    protected $table = "exit_work_tax_details";
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
    
    public function item(){
        return $this -> belongsTo(\App\Models\Item::class ,'item_id');
    }


}
