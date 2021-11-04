<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    protected $table = "bodycircular";
	protected $primaryKey = "bcId";
    protected $fillable = ['bcName','bcDescription'];
	public $timestamps = false;
}
