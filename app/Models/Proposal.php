<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = "proposals";

    protected $fillable = [
    	'id',
    	'proDateQuotation',
    	'proScheduling_id',
    	'proCustomer_id',
    	'proGrade_id',
    	'proAdmission_id',
    	'proJourney_id',
    	'proFeeding_id',
    	'proUniform_id',
        'proSupplie_id',
        'proTransport_id',
    	'proExtracurricular_id',
    	'proValueQuotation',
    	'proStatus',
    	'proResult',
    ];

    public $timestamps = false;
}
