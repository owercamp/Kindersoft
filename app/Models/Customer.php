<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customers";

    protected $fillable = [
        'id',
        'cusFirstname',
        'cusLastname',
        'cusPhone',
        'cusMail',
        'cusContact',
        'cusChild',
        'cusChildYearsold',
        'cusNotes',
        'cusVisible',
    ];

    public $timestamps = false;
}
