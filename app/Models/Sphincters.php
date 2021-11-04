<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sphincters extends Model
{
    protected $table = "sphincters";
    protected $primaryKey = "spId";
    protected $fillable = [
    	'spDate',
        'spLegalization_id',
        'spNews'
    ];
    public $timestamps = false;
}
