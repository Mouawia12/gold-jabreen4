<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetails extends Model
{
    protected $table = "inventory_details";
    protected $fillable = [
        'inventory_id', 'date', 'karat_id', 'item_id','weight'
        , 'new_weight', 'state', 'user_id'
    ];

    public function karat(){
        return $this -> belongsTo(\App\Models\Karat::class ,'karat_id' );
     }
 
     public function item(){
         return $this -> belongsTo(\App\Models\Item::class ,'item_id' );
     }
}
