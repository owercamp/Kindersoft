<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intelligence extends Model
{
    protected $table = "intelligences";

    protected $fillable = ['id','type','description'];

    public $timestamps = false;
}
