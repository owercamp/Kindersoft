<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Numbercircular extends Model
{
    protected $table = "numberscircular";
	protected $primaryKey = "ncId";
    protected $fillable = ['ncCode','ncDate','ncTo','ncMessage','ncFrom_id'];
	public $timestamps = false;
}
