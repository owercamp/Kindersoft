<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = "achievements";

    protected $fillable = ['id','name','description','intelligence_id'];

    public $timestamps = false;
}
