<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitMoney extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'branch_id',
        'doc_number',
        'date',
        'supplier_id',
        'amount',
        'payment_method',
        'based_on',
        'based_on_bill_number',
        'type',
        'price_gram',
        'notes',
        'user_id',
    ];
}
