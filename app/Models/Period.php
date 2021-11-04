<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = "periods";

    protected $fillable = [
        'id','name', 'grade_id', 'initialDate', 'finalDate'
    ];

    public $timestamps = false;
}
