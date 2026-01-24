<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [  'date', 'invoice_no', 'customer_id', 'biller_id', 'warehouse_id'
                             , 'total', 'discount', 'tax', 'net', 'paid', 'sale_status', 'payment_status'
                             , 'pos', 'lista', 'profit', 'additional_service', 'note', 'user_id' ];
}
