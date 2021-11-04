<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheduling extends Model
{
    protected $table = "schedulings";

    protected $fillable = [
        'id',
        'schCustomer_id',
        'schDateVisit',
        'schDayVisit',
        'schHourVisit',
        'schStatusVisit',
        'schResultVisit',
        'schObservation',
        'schQuoted',
        'schColor',
        'schMails'
    ];

    public $timestamps = false;
}
