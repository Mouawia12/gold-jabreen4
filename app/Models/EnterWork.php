<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_id',
        'bill_number',
        'bill_type' ,
        'supplier_bill_number',
        'date',
        'supplier_id',
        'total_money',
        'total21_gold',
        'paid_money',
        'remain_money',
        'paid_gold',
        'remain_gold',
        'made_total',
        'discount', 
        'tax', 
        'net_money',
        'returned_bill_id',
        'pos',
        'notes',
        'user_id',

        ];


     public function branch(){
         return $this -> belongsTo(\App\Models\Branch::class ,'branch_id');
     }

     public function supplier(){
        return $this -> belongsTo(\App\Models\Company::class ,'supplier_id');
    }
}
