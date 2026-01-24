<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountMovement extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'journal_id', 'account_id', 'credit', 'debit', 'date', 'notes'
    ];
}
