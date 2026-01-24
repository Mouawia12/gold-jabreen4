<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitWorkDetails2 extends Model
{
    use HasFactory;
    public $connection = 'pgsql';
    public $table = 'exit_work_details';
    protected $fillable = [
        'id',
        'bill_id',
        'item_id',
        'karat_id',
        'weight',
        'gram_price',
        'gram_manufacture',
        'gram_tax',
        'net_money',
        'returned'
    ];



}
