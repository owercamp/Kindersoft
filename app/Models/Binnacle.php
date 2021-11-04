<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $table = "binnacle";
	protected $primaryKey = "binId";
    protected $fillable = ['binProposal_id','binDate','binObservation'];
	public $timestamps = false;
}
