<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $table = "paids";
	protected $primaryKey = "payId";
    protected $fillable = [
    	'payValueContract',
    	'payDuesQuotationContract',
    	'payValuemountContract',
    	'payDatepaidsContract',
    	'payValueEnrollment',
    	'payDuesQuotationEnrollment',
    	'payValuemountEnrollment',
    	'payDatepaidsEnrollment',
    	'payLegalization_id'
    ];
	public $timestamps = false;
}
