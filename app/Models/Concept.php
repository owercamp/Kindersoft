<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    protected $table = "concepts";
    protected $primaryKey = "conId";
    protected $fillable = [
    	'conDate',
    	'conConcept',
    	'conValue',
    	'conStatus',
    	'conLegalization_id'
    ];
    public $timestamps = false;
}
