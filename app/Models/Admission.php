<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $table = "admissions";
    protected $fillable = [
        'id','admConcept','admValue'
    ];
    public $timestamps = false;
}
