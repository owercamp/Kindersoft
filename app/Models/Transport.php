<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table = "transports";
    protected $fillable = [
        'id','traConcept','traValue'
    ];
    public $timestamps = false;
}
