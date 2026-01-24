<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationWahtsapp extends Model
{
    use HasFactory; 
    public $table = 'notification_wahtsapp';
    //public $timestamps = false;
    protected $fillable = [ 
       'bill_number','client_phone', 'user_id','status'
    ];
}
