<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Bulletin;
use App\Models\Student;
use App\Models\Course;
use App\Models\Academicperiod;
use App\Models\Chronological;
use App\Models\Weeklytracking;
use App\Models\Intelligence;
use App\Models\Trackingachievement;
use App\Models\Achievement;
use App\Models\Obserbull;
use App\Models\Garden;
use App\Models\CourseConsolidated;
use App\Models\Observation;
use Psy\Exception\Exception;

class BulletinsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function bulletinTo(){
    	$students = Student::select('id', 'status' ,DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"))->join('weeklytrackings','weeklytrackings.wtStudent_id','students.id')->where('weeklytrackings.wtStudent_id','>',0)->distinct('weeklytrackings.wtStudent_id')->get();
        return view('modules.evaluations.bulletins',compact('students'));
    }

    function newslettersTo(){
        $students = Student::select('id', 'status' ,DB::raw("CONCAT(students.firstname,' ',students.threename,' ',students.fourname) AS nameStudent"))->join('weeklytrackings','weeklytrackings.wtStudent_id','students.id')->where('weeklytrackings.wtStudent_id','>',0)->distinct('weeklytrackings.wtStudent_id')->get();
        return view('modules.evaluations.newsletters', compact('students'));
    }

    function newslettersPdf(Request $request){
        // dd($request->all());
        /*
			$request->buStudent_id
			$request->buCourse_id
			$request->buPeriod_id
			$request->buGrafic_id
			$request->buIntelligences
        */
        $infoIntelligence = array();
        $infoAchievement = array();
        $intelligences = Intelligence::all();
        foreach ($intelligences as $intelligence) {
            $weeklytrackings = Weeklytracking::where('wtCourse_id',trim($request->buCourse_id))
                                    ->where('wtPeriod_id',trim($request->buPeriod_id))
                                    ->where('wtStudent_id',trim($request->buStudent_id))
                                    ->where('wtIntelligence_id',$intelligence->id)
                                    ->get();
            foreach ($weeklytrackings as $weeklytracking) {
                $achievement = Achievement::find($weeklytracking->wtAchievement_id);
                array_push($infoAchievement, [$intelligence->id,$achievement->name, $weeklytracking->wtNote, $weeklytracking->wtStatus]);
            }
            array_push($infoIntelligence, [$intelligence->id,$intelligence->type]);
        }
        $resultIntelligences = array();
        $separatedIntelligence = explode(':',trim($request->buIntelligences));
        for ($i=0; $i < count($separatedIntelligence); $i++) { 
        	$separatedIntelligenceItems = explode('=',$separatedIntelligence[$i]);
        	array_push($resultIntelligences,[
        		$separatedIntelligenceItems[0],
        		$separatedIntelligenceItems[1]
        	]);
        }
        $student = Student::find(trim($request->buStudent_id));
        $course = Course::find(trim($request->buCourse_id));
        $period = Academicperiod::find(trim($request->buPeriod_id));
        if($course !== null && $student !== null && $period !== null){
            $namefile = $student->firstname . '_' . $student->threename . '_' . $period->apNameperiod . '_INFORME_DE_PERIODO.pdf';
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadView('modules.evaluations.bulletinPdf',
                            compact(
                                'period',
                                'course',
                                'student',
                                'infoIntelligence',
                                'infoAchievement',
                                'resultIntelligences'
                            )
                        );
            return $pdf->download($namefile);
        }
    }

    function bulletinPdf(Request $request){
        try{
            // dd($request->all());
            $observations = Trackingachievement::where('taCourse_id',$request->buCourse_id)
                                        ->where('taPeriod_id',$request->buPeriod_id)
                                        ->where('taStudent_id',$request->buStudent_id)
                                        ->first();
            $observationsPeriod = array();
            if($observations != null){
                if(strlen($observations->taObservations) > 0){
                    $allObservations = substr(trim($observations->taObservations),0,-1);
                    $idsObservations = explode(':',$allObservations);
                    $intelligences = Intelligence::all();
                    foreach ($intelligences as $intelligence) {
                        $items = array();

                        for ($i=0; $i < count($idsObservations); $i++) { 
                            $getObservationsFromIntelligence = Observation::select('intelligences.*','observations.*')
                                                ->join('intelligences','intelligences.id','observations.obsIntelligence_id')
                                                ->where('obsIntelligence_id',$intelligence->id)
                                                ->where('obsId',$idsObservations[$i])
                                                ->first();
                            if($getObservationsFromIntelligence != null) {
                                array_push($items,[
                                    $getObservationsFromIntelligence->obsNumber,
                                    $getObservationsFromIntelligence->obsDescription
                                ]);
                            }
                        }
                        if(count($items) > 0){
                            array_push($observationsPeriod,[
                                $intelligence->type,
                                $items
                            ]);
                        }else{
                            array_push($observationsPeriod,[
                                $intelligence->type,
                                'N/A'
                            ]);
                        }
                    }
                    
                }else{
                    $observationsPeriod = 'N/A';
                }
            }else{
                $observationsPeriod = 'N/A';
            }
            $student = Student::find(trim($request->buStudent_id));
            $course = Course::find(trim($request->buCourse_id));
            $period = Academicperiod::find(trim($request->buPeriod_id));

            $garden = Garden::select('garden.garNamerepresentative')->first();
            $collaborator = CourseConsolidated::select(
                        DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                    )
                    ->join('collaborators','collaborators.id','coursesconsolidated.ccCollaborator_id')
                    ->where('ccCourse_id',$course->id)->first();
            if($course !== null && $student !== null && $period !== null){
                $namefile = $student->firstname . '_' . $student->threename . '_' . $period->apNameperiod . '_BOLETIN.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadView('modules.evaluations.bulletinSchoolPdf',
                                compact(
                                    'period',
                                    'course',
                                    'student',
                                    'observationsPeriod',
                                    'garden',
                                    'collaborator'
                                )
                            );
                return $pdf->download($namefile);
            }
            return response()->json($intelligence);
        }catch(Exception $ex){

        }
    }
}
