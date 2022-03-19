<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;
use App\Models\Student;
use App\Models\Intelligence;
use Illuminate\Http\Request;
use App\Models\Academicperiod;
use App\Models\Weeklytracking;
use App\Models\CourseConsolidated;
use App\Models\Trackingachievement;

class WeeklytrackingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function weeklyTrackingTo(){
    	$courses = CourseConsolidated::select('courses.*')->join('courses','courses.id','coursesconsolidated.ccCourse_id')->get();
    	$intelligences = Intelligence::select('id','type')->get();
    	//$students = Listcourse::select('students.id as idStudent',DB::raw("CONCAT(students.firstname,' ',students.secondname,' ',students.threename,' ',students.fourname) AS nameStudent"))->join('students','students.id','listcourses.listStudent_id')->get();
        return view('modules.evaluations.weeklytracking', compact('courses','intelligences'));
    }

    function newWeekTracking(Request $request){
        try{
            // dd($request->all());
            /*
                $request->wtCourse;
                $request->wtPeriod;
                $request->wtChronological;      // SEMANA SELECCIONADA
                $request->wtStudent_id;
                $request->wtIntelligence_id;
                $request->allPorcentages; 

                // Ejemplo: IDBASE:IDINTELLIGENCE:IDACHIEVEMENT:NOTA%:ESTADO=IDBASE:IDINTELLIGENCE:IDACHIEVEMENT:NOTA%:ESTADO=
                
                $request->wtIntelligence_id; // Ya no se usar a partir de actualización
                $request->wtAchievement_id; // Ya no se usar a partir de actualización


            */
             $achievements = substr(trim($request->allPorcentages),0,-1); // QUITAR ULTIMO CARACTER QUE ES (=)
             $separatedNotes = explode('=',$achievements);
             $countSave = 0;
             $student = Student::find(trim($request->wtStudent_id));
             $course = Course::find(trim($request->wtCourse));
             $period = Academicperiod::find(trim($request->wtPeriod));
             for ($i=0; $i < count($separatedNotes); $i++) {
                $separated = explode(':',$separatedNotes[$i]);
                /*
                    $separated[0] => wtBaseactivity_id
                    $separated[1] => wtIntelligence_id
                    $separated[2] => wtAchievement_id
                    $separated[3] => wtNote
                    $separated[4] => wtStatus
                */
                $onlyNumber = substr($separated[3],0,-1);
                $weeklytrackingValidate = Weeklytracking::where('wtCourse_id',trim($request->wtCourse))
                                                    ->where('wtPeriod_id',trim($request->wtPeriod))
                                                    ->where('wtChronological_id',trim($request->wtChronological))
                                                    ->where('wtStudent_id',trim($request->wtStudent_id))
                                                    ->where('wtBaseactivity_id',$separated[0])
                                                    ->where('wtIntelligence_id',$separated[1])
                                                    // ->where('wtAchievement_id',$separated[2])
                                                    ->first();
                if($weeklytrackingValidate == null){
                    Weeklytracking::create([
                        'wtCourse_id' => trim($request->wtCourse),
                        'wtPeriod_id' => trim($request->wtPeriod),
                        'wtChronological_id' => trim($request->wtChronological),
                        'wtStudent_id' => trim($request->wtStudent_id),
                        'wtBaseactivity_id' => $separated[0],
                        'wtIntelligence_id' => $separated[1],
                        'wtAchievement_id' => $separated[2],
                        'wtNote' => $onlyNumber,
                        'wtStatus' => $separated[4]
                    ]);
                    $countSave++;
                }
            }
            if($countSave > 0){
                return redirect()->route('weeklyTracking')->with('SuccessSaveWeekTracking', 'Se han registrado ' . $countSave . ' logro/s para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' del curso ' . $course->name . ' en el ' . $period->apNameperiod . ', Consulte en la opción Cierre de periodo académico');
            }else{
                return redirect()->route('weeklyTracking')->with('SecondarySaveWeekTracking', 'Ya existen los logros para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' del curso ' . $course->name . ' en la misma semana del periodo ' . $period->apNameperiod . ', Consulte en la opción Cierre de periodo académico');
            }
        }catch(Exception $ex){
            return redirect()->route('weeklyTracking')->with('SecondarySaveWeekTracking', 'No es posible establecer el cronograma ahora, comuniquese con el administrador');
        }
    }

    function saveWeekTracking(Request $request){
        // dd($request->all());
        // dd($request->rowsObservations);
        /*
            $request->idCourse_modalObservation             // id course
            $request->idPeriod_modalObservation             // id period
            $request->idStudent_modalObservation            // id student
            $request->idsTrackingsNotes_modalObservation    // idTrack=>Note 13=>77,14=>85,26=>67,16=>76,17=>84,28=>63,29=>54,30=>21,27=>76
            $request->taIntelligence_id                     // id intelligence (not use)
            $request->taObservation_id                      // id observation (not use)
            $request->rowsObservations                      // ids observations (-delete for remove of table)  4=7-delete=9=10=11-delete=12=13-delete=6=
        */

        $weeklytrackingCount = Weeklytracking::where('wtCourse_id',trim($request->idCourse_modalObservation))
                                    ->where('wtPeriod_id',trim($request->idPeriod_modalObservation))
                                    ->where('wtStudent_id',trim($request->idStudent_modalObservation))
                                    ->get()->count();
        $course = Course::find(trim($request->idCourse_modalObservation));
        $period = Academicperiod::find(trim($request->idPeriod_modalObservation));
        $student = Student::find(trim($request->idStudent_modalObservation));
        if($weeklytrackingCount > 0){
            // 1.) ACTUALIZAR CADA NOTA DEL PERIODO DEL ALUMNO
            // (No se usa a partir de actualización ya que el módulo solo es informactivo, no se pueden canbiar notas)
            // $separatedWeeklys = explode(',', trim($request->idsTrackingsNotes_modalObservation));
            // for ($i=0; $i < count($separatedWeeklys); $i++) { 
            //     $separatedNote = explode('=>', $separatedWeeklys[$i]);
            //     /*
            //         $separatedNote[0] => id de weeklytracking  
            //         $separatedNote[1] => note de weektracking  
            //     */
            //     $weeklyTracking = Weeklytracking::find($separatedNote[0]);
            //     if($weeklyTracking != null){
            //         $statusNote = $this->getStatusAchievement($separatedNote[1]);
            //         $weeklyTracking->wtNote = $separatedNote[1];
            //         $weeklyTracking->wtStatus = $statusNote;
            //         $weeklyTracking->save();
            //     }
            // }

            // 2.) ACTUALIZAR IDS DE OBSERVACIONES DEL PERIODO
            if(trim($request->rowsObservations) != null){
                $ids = '';
                $separatedIds = explode('=',trim($request->rowsObservations));
                for ($o=0; $o < count($separatedIds); $o++) { 
                    $findDelete = strpos($separatedIds[$o],'delete');
                    if($findDelete === false){
                        if($o == (count($separatedIds) -1)){
                            $ids .= $separatedIds[$o];
                        }else{
                            $ids .= $separatedIds[$o] . ':';
                        }
                    }
                }
                $observation = Trackingachievement::where('taCourse_id',trim($request->idCourse_modalObservation))
                                                    ->where('taPeriod_id',trim($request->idPeriod_modalObservation))
                                                    ->where('taStudent_id',trim($request->idStudent_modalObservation))
                                                    ->first();
                // $allObservations = substr($ids,0,-1); // QUITAR ULTIMO CARACTER (:)
                if($observation != null){
                    $observation->taObservations = $ids;
                    $observation->save();
                }else{
                    Trackingachievement::create([
                        'taCourse_id' => trim($request->idCourse_modalObservation),
                        'taPeriod_id' => trim($request->idPeriod_modalObservation),
                        'taStudent_id' => trim($request->idStudent_modalObservation),
                        'taObservations' => $ids
                    ]);
                }
            }
            return redirect()->route('periodClosing')->with('SuccessSavePeriodClose', 'Se ha actualizado el cierre de periodo para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' en el ' . $period->apNameperiod);
        }else{
            return redirect()->route('periodClosing')->with('SecondarySavePeriodClose', 'No hay seguimientos para ' . $student->firstname . ' ' . $student->threename . ' ' . $student->fourname . ' del ' . $period->apNameperiod . ' en el grado ' . $course->name);
        }
    }

    function getStatusAchievement($note){
        if($note >= 0 && $note <= 25){
            return 'PENDIENTE';
        }else if($note >= 26 && $note <= 50){
            return 'INICIADO';
        }else if($note >= 51 && $note <= 75){
            return 'EN PROCESO';
        }else if($note >= 76 && $note <= 99){
            return 'POR TERMINAR';
        }else if($note >= 100){
            return 'COMPLETADO';
        }
    }
}
