<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extratime extends Model
{
    protected $table = "extratimes";
    protected $fillable = [
        'id','extTConcept','extTValue'
    ];
    public $timestamps = false;
}
