<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Grade;
use App\Models\Course;
use App\Models\Collaborator;
use App\Models\CourseConsolidated;
use App\Models\Listcourse;
use App\Models\Student;
use App\Models\ActivityClass;
use App\Models\ActivitySpace;
use App\Models\Hourweek;
use App\Models\Observation;

use App\Models\Weeklytracking;
use App\Models\Trackingachievement;
use App\Models\Achievement;
use App\Models\Intelligence;

use App\Models\Bulletin;
use App\Models\Obserbull;
use App\Models\Academicperiod;
use App\Models\Chronological;

use App\Models\Baseactivity;
use Psy\Exception\Exception;

class AcademicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function structureTo(){
        return view('modules.structure');
    }
    
    /* -- EVALUACION ESCOLAR -- */


    function periodClosingTo(){
        $students = Student::select('id', 'status' ,DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"))->join('weeklytrackings','weeklytrackings.wtStudent_id','students.id')->where('weeklytrackings.wtStudent_id','>',0)->distinct('weeklytrackings.wtStudent_id')->get();
        $observations = Observation::all();
        return view('modules.evaluations.periodclosing', compact('students','observations'));
    }

    function savePeriodClosing(Request $request){
        try{
            //dd($request->datesObservations);
            if($request->idBulletin == null || $request->idBulletin == ''){
                Bulletin::create([
                    'buStudent_id' => trim($request->idStudent),
                    'buCourse_id' => trim($request->idCourse),
                    'buPeriod_id' => trim($request->idPeriod)
                ]);
                $bulletin = Bulletin::where('buStudent_id',trim($request->idStudent))
                                    ->where('buCourse_id',trim($request->idCourse))
                                    ->where('buPeriod_id',trim($request->idPeriod))
                                    ->first();
                //CREAR LAS OBSERVACIONES PARA EL BOLETIN ESCOLAR
                for ($i=0; $i < count($request->datesObservations); $i++){
                    Obserbull::create([
                        'obuObservation_id' => $request->datesObservations[$i],
                        'obuBulletin_id' => $bulletin->buId
                    ]);
                }
                $period = Academicperiod::find(trim($request->idPeriod));
                $student = Student::find(trim($request->idStudent));
                return response()->json($period->apNameperiod . ' PARA ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' CERRADO CORRECTAMENTE');
                //return redirect()->route('periodClosing')->with('SuccessSavePeriodClose');
            }else{
                $bulletin = Bulletin::where('buStudent_id',trim($request->idStudent))
                                    ->where('buCourse_id',trim($request->idCourse))
                                    ->where('buPeriod_id',trim($request->idPeriod))
                                    ->where('buId',trim($request->idBulletin))
                                    ->first();
                for ($i=0; $i < count($request->datesObservations); $i++) { 
                    $observationBulletinValidate = Obserbull::where('obuObservation_id',$request->datesObservations[$i])
                                                ->where('obuBulletin_id',$bulletin->buId)->first();
                    if($observationBulletinValidate == null){
                        Obserbull::create([
                            'obuObservation_id' => $request->datesObservations[$i],
                            'obuBulletin_id' => $bulletin->buId
                        ]);
                    }
                }
                $period = Academicperiod::find(trim($request->idPeriod));
                $student = Student::find(trim($request->idStudent));
                return response()->json($period->apNameperiod . ' PARA ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' REESCRITO CORRECTAMENTE');
                //return redirect()->route('periodClosing')->with('SuccessSavePeriodClose', $period->apNameperiod . ' PARA ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' REESCRITO CORRECTAMENTE');
            }
        }catch(Exception $ex){
            return response()->json('No es posible cerrar el periodo ahora, Comuníquese con el administrador');
            //return redirect()->route('periodClosing')->with('SecondarySavePeriodClose');
        }
    }

    /*============================================================================================
        BASE DE ACTIVIDADES (Gestión academica >> programación escolar >> base de actividades)
    ============================================================================================*/

    function baseactivitysTo(){
        $bases = Baseactivity::select(
                    'baseactivitys.*',
                    'intelligences.type as nameIntelligence'
                )
                ->join('intelligences','intelligences.id','baseactivitys.baIntelligence_id')
                ->get();
        $intelligences = Intelligence::all();
        return view('modules.base.activitys',compact('bases','intelligences'));
    }

    function saveBaseactivity(Request $request){
        // dd($request->all());
        $validate = Baseactivity::where('baDescription',ucfirst(mb_strtolower(trim($request->baDescription),'UTF-8')))
                                        ->where('baIntelligence_id',trim($request->baIntelligence_id))
                                        ->first();
        if($validate == null){
            Baseactivity::create([
                'baDescription' => ucfirst(mb_strtolower(trim($request->baDescription),'UTF-8')),
                'baIntelligence_id' => trim($request->baIntelligence_id)
            ]);
            $intelligence = Intelligence::find(trim($request->baIntelligence_id));
            return redirect()->route('baseactivitys')->with('SuccessBases', 'Base de actividad de ' . $intelligence->type . ', registrada');
        }else{
            return redirect()->route('baseactivitys')->with('SecondaryBases', 'Ya existe la base de actividad con la descripción e inteligencia seleccionada');
        }   
    }

    function updateBaseactivity(Request $request){
        // dd($request->all());
        $validateOther = Baseactivity::where('baDescription',ucfirst(mb_strtolower(trim($request->baDescription_Edit),'UTF-8')))
                                        ->where('baIntelligence_id',trim($request->baIntelligence_id_Edit))
                                        ->where('baId','!=',trim($request->baId_Edit))
                                        ->first();
        if($validateOther == null){
            $validate = Baseactivity::find(trim($request->baId_Edit));
            if($validate != null){
                $validate->baDescription = ucfirst(mb_strtolower(trim($request->baDescription_Edit),'UTF-8'));
                $validate->baIntelligence_id = trim($request->baIntelligence_id_Edit);
                $validate->save();
                $intelligence = Intelligence::find(trim($request->baIntelligence_id_Edit));
                return redirect()->route('baseactivitys')->with('PrimaryBases', 'Base de actividad de ' . $intelligence->type . ', actualizada');
            }else{
                return redirect()->route('baseactivitys')->with('SecondaryBases', 'No se encuentra la base de actividad, consulte al administrador');
            }
        }else{
            return redirect()->route('baseactivitys')->with('SecondaryBases', 'Ya existe la base de actividad con la descripción e inteligencia, consulte la tabla');
        }
    }

    function deleteBaseactivity(Request $request){
        // dd($request->all());
        $validate = Baseactivity::find(trim($request->baId_Delete));
        if($validate != null){
            $name = $validate->baDescription;
            $intelligence = Intelligence::find($validate->baIntelligence_id);
            $validate->delete();
            return redirect()->route('baseactivitys')->with('WarningBases', 'Base de actividad de ' . $intelligence->type . ', eliminada');
        }else{
            return redirect()->route('baseactivitys')->with('SecondaryBases', 'No se encuentra el municipio, Consulte con el administrador');
        }
    }
}

