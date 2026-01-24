<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'group_name',
        'customer_group_id',
        'customer_group_name',
        'name',
        'company',
        'vat_no',
        'address',
        'building',
        'city',
        'city_sub',
        'state',
        'postal_code',
        'country',
        'email',
        'phone',
        'invoice_footer',
        'logo',
        'award_points',
        'opening_balance',
        'account_id',
        'credit_amount',
        'deposit_amount',
        'credit_gold',
        'deposit_gold',
        'stop_sale',
        'account_id',
        'user_id'
    ];

    public function account(){
        return $this -> belongsTo('App\Models\AccountsTree','account_id','id' );
     }
}
