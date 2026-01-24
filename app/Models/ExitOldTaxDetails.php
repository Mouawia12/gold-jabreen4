<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitOldTaxDetails extends Model
{
    protected $table = "exit_old_tax_details";
    protected $fillable = [
        'id',
        'bill_id',
        'karat_id',
        'weight',
        'weight21',
        'made_money',
        'net_weight',
        'net_money',
        'gram_manufacture',
        'gram_tax',
        'gram_price',
        'returned'
    ];
}
