<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'branch_id','date', 'basedon_no', 'basedon_id', 'baseon_text'
        , 'total_credit', 'total_debit'
    ];
  

}
