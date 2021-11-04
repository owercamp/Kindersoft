<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $table = "extracurriculars";
    protected $fillable = [
        'id','extConcept','extIntensity','extValue'
    ];
    public $timestamps = false;
}
