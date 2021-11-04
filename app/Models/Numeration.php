<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Numeration extends Model
{
    protected $table = "numbersInitial";
	protected $primaryKey = "niId";
    protected $fillable = [
    	'niFacture',
    	'niVoucherentry',
    	'niVoucheregress'
    ];
	public $timestamps = false;
}
