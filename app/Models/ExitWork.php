<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'uuid',
        'branch_id',
        'bill_number',
        'date',
        'client_id',
        'client_phone',
        'total_money',
        'total21_gold',
        'paid_money',
        'remain_money',
        'paid_gold',
        'remain_gold',
        'discount',
        'tax',
        'net_money',
        'returned_bill_id',
        'bill_client_name',
        'pos',
        'qr',
        'response',
        'invoice_hash',
        'notes',
        'user_id' 

    ];

    public function branch(){
        return $this -> belongsTo(\App\Models\Branch::class ,'branch_id');
    }

    public function company(){
        return $this -> belongsTo(\App\Models\Company::class ,'client_id');
    }

    public function cash(){
        return $this -> belongsTo(EnterMoney::class ,'bill_number','based_on_bill_number')->where('payment_method',0);
    }

    public function visa(){
        return $this -> belongsTo(EnterMoney::class ,'bill_number','based_on_bill_number')->where('payment_method',1);
    }
}
