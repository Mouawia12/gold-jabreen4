<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, $id)
 * @method static findOrFail($admin_id)
 */
class File extends Model
{
    protected $table = "files";

    protected $fillable = [
        'name', 'type'
    ];

    public function admin(){
        return $this->hasMany('\App\Models\Admin','branch_id','id');
    }
 
}
