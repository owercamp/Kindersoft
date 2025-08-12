<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Attendant;
use Illuminate\Database\Eloquent\Model;

class Legalization extends Model
{
    protected $table = "legalizations";
	protected $primaryKey = "legId";
    protected $fillable = ['legStudent_id','legAttendantfather_id','legAttendantmother_id','legGrade_id','legJourney_id','legDateInitial','legDateFinal','legDateCreate','legStatus','legArgument'];
	public $timestamps = false;

    /** RELACION CON MIS ESTUDIANTES **/
    public function student()
    {
        return $this->belongsTo(Student::class,'legStudent_id','id');
    }

    /** RELACION CON MI PADRE **/
    public function father()
    {
        return $this->belongsTo(Attendant::class, 'legAttendantfather_id','id');
    }

    /** RELACION CON MI MADRE **/
    public function mother()
    {
        return $this->belongsTo(Attendant::class,'legAttendantmother_id','id');
    }

    /** RELACION CON MI GRADO **/
    public function grade()
    {
        return $this->belongsTo(Grade::class,'legGrade_id','id');
    }

    /** RELACION CON MI JORNADA **/
    public function journey()
    {
        return $this->belongsTo(Journey::class,'legJourney_id','id');
    }

    /** RELACION CON MIS CONCEPTOS **/
    public function concept()
    {
        return $this->belongsTo(Concept::class,'legId','conLegalization_id');
    }


}
