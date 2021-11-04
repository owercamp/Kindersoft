<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplie extends Model
{
    protected $table = "supplies";
    protected $fillable = [
        'id','supConcept','supValue'
    ];
    public $timestamps = false;
}
