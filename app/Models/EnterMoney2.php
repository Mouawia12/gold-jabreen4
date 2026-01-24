<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterMoney2 extends Model
{
    use HasFactory;
    public $connection = 'mysql2';
    public $table = 'enter_money';
    protected $fillable = [
        'id',
        'doc_number',
        'date',
        'client_id',
        'amount',
        'payment_method',
        'based_on',
        'based_on_bill_number',
        'notes',
        'user_id'

    ];
}
