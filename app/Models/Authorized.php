<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorized extends Model
{
    protected $table = "authorized";
    protected $primaryKey = "autId";
    protected $fillable = [
        'autFirstname',
        'autLastname',
        'autDocument_id',
        'autNumberdocument',
        'autPhoneone',
        'autPhonetwo',
        'autRelationship',
        'autObservations',
        'autPhoto'
    ];
    public $timestamps = false;
}
