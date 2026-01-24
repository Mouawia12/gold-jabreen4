<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item3 extends Model
{
    use HasFactory;
    public $connection = 'pgsql';
    public $table = 'items';
    //public $timestamps = false;
    protected $fillable = [ 
        'code',
        'name_ar',
        'name_en', 
        'category_id',
        'karat_id',
        'weight',
        'no_metal',
        'no_metal_type',
        'made_Value',
        'item_type',
        'tax',
        'price',
        'cost',
        'state',
        'img',
        'quantity', 
        'user_id',
        'supplier_id',
        'supplier_bill_number', 
    ];
 
}
