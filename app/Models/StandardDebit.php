<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardDebit extends Model
{
    use HasFactory;
    protected $table = 'standard_debit';
    protected $fillable = [ 
        'uuid','serial_number' ,'branch_id', 'reference_id', 
        'bill_number', 'date', 'client_id', 'total_money',
        'total21_gold', 'paid_money', 'remain_money',
        'paid_gold', 'remain_gold', 'discount', 'tax',
        'net_money', 'qr', 'response', 'invoice_hash','user_id'
    ];

    public function branch(){
        return $this -> belongsTo(\App\Models\Branch::class ,'branch_id');
    }

    public function company(){
        return $this -> belongsTo(\App\Models\Company::class ,'client_id');
    }

    public function invoice(){
        return $this -> belongsTo(\App\Models\ExitWorkTax::class ,'reference_id');
    }
}
