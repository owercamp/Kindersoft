<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    protected $table = "feedings";
    protected $fillable = [
        'id','feeConcept','feeValue'
    ];
    public $timestamps = false;
}
