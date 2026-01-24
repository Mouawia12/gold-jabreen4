<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatchGoldReciptsDetails extends Model
{
    use HasFactory;

    protected $table = "catch_gold_recipts_details";
    
    protected $fillable = [
        'bill_id', 'karat_id', 'type', 'weight', 'weight21'
    ];

    public function elements(){
        return $this->hasMany(\App\Models\CatchGoldRecipts::class,'bill_id','id');
    }
}
