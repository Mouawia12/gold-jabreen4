<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable  implements JWTSubject
{
    use HasRoles;

    protected $table = 'admins';

    protected $fillable = [
        'name', 'email', 'password', 'phone_number','branch_id','role_name', 'status', 'remember_token', 'created_at', 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token' 
    ];
    public function branch(){
        return $this->belongsTo('\App\Models\Branch','branch_id','id');
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
