<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterMoney extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_id',
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
