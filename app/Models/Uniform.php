<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uniform extends Model
{
    protected $table = "uniforms";
    protected $fillable = [
        'id','uniConcept','uniValue'
    ];
    public $timestamps = false;
}
