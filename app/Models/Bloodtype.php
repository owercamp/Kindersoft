<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloodtype extends Model
{
    protected $table = "bloodtypes";

    protected $fillable = ['id','group','type'];

    public $timestamps = false;
}
