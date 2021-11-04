<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    protected $table = "healths";
    
    protected $fillable = [
        'id','entity','type'
    ];

    public $timestamps = false;
}
