<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tst extends Model
{
    use HasFactory;
    public $connection = 'pgsql';
    public $table = 'tst';
    public $timestamps = false;
    protected $fillable = [ 
        'name'
    ];

      
}
