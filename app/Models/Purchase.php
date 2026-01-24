<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'branch_id',
        'invoice_no',
        'customer_id',
        'biller_id',
        'warehouse_id',
        'total',
        'discount',
        'tax',
        'net',
        'paid',
        'purchase_status',
        'payment_status',
        'returned_bill_id',
        'note',
        'user_id',
    ];
}
