<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSetting extends Model
{
    use HasFactory;
    protected $table = "program_settings";
    protected $fillable = [
        'branche', 'users', 'items','status'
    ];
}
