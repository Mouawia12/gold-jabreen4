<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    protected $table = "warehouses_items";

    protected $fillable = [
        'id',
        'branch_id',
        'type',
        'item_id',
        'enter',
        'out',
        'bill_id',
        'date',
        'user_id',
    ];
}
