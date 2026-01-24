<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingClosing extends Model
{
    use HasFactory;
    protected $table = 'accounting_closing'; 
    protected $fillable = [
        'account_debit', 'account_credit', 'account_id', 'status'
    ];

}
