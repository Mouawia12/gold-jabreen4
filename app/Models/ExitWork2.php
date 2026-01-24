<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitWork2 extends Model
{
    use HasFactory;
    public $connection = 'pgsql';
    public $table = 'exit_works';
    protected $fillable = [
        'id',
        'bill_number',
        'date',
        'client_id',
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
        'notes',
        'user_id' 

    ];
}
