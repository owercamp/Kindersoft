<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;

use App\Models\Collaborator;
use App\Models\Intelligence;
use Illuminate\Http\Request;
use App\Models\Chronological;
use App\Models\Academicperiod;
use App\Models\CourseConsolidated;
use Illuminate\Support\Facades\DB;

class ChronologicalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function planningTo(){
    	$courses = CourseConsolidated::select('courses.*')->join('courses','courses.id','coursesconsolidated.ccCourse_id')->get();
    	/*$courses = Academicperiod::select('academicperiods.*','courses.name As nameCourse')
    						->join('courses','courses.id','academicperiods.apCourse_id')
    						->where('academicperiods.apStatus','ACTIVO')
    						->get();
    						dd($courses);*/
    	$intelligences = Intelligence::select('id','type')->get();
    	$collaborators = Collaborator::select('id', DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator"))->get();
        return view('modules.programming.planning', compact('courses','intelligences','collaborators'));
    }

    function newPlanning(Request $request){
        try{
            // dd($request->all());
            /*
                $request->chCourse;
                $request->chNameCourse;
                $request->chPeriod;
                $request->chRangeWeek;
                $request->chNumberWeek;
                $request->chCollaborator_id;
                $request->chIntelligence_id;
                $request->chDescription; // Ya no se usa a partir de actualización (Modificación #13)
                $request->chBases_id;
                $request->chBases; // Ids de las bases de actividades seleccionadas
                $ids = substr(trim($request->chBases),0,-1); // QUITAR ULTIMO CARACTER QUE ES (:)
            */
            //dd(trim(ucfirst(mb_strtolower($request->chDescription,'UTF-8'))));
            $chronologicalValidate = Chronological::where('chCourse_id',trim($request->chCourse))
                                                ->where('chAcademicperiod_id',trim($request->chPeriod))
                                                ->where('chRangeWeek',trim($request->chRangeWeek))
                                                ->where('chNumberWeek',trim($request->chNumberWeek))
                                                ->where('chIntelligence_id',trim($request->chIntelligence_id))
                                                ->first();
            $intelligence = Intelligence::find(trim($request->chIntelligence_id));
            if($chronologicalValidate == null){
                $ids = substr(trim($request->chBases),0,-1); // QUITAR ULTIMO CARACTER QUE ES (:)
                Chronological::create([
                    'chCourse_id' => trim($request->chCourse),
                    'chAcademicperiod_id' => trim($request->chPeriod),
                    'chRangeWeek' => trim($request->chRangeWeek),
                    'chNumberWeek' => trim($request->chNumberWeek),
                    'chIntelligence_id' => trim($request->chIntelligence_id),
                    'chCollaborator_id' => trim($request->chCollaborator_id),
                    // 'chDescription' => trim(ucfirst(mb_strtolower($request->chDescription,'UTF-8'))),
                    'chBases' => $ids
                ]);
                return redirect()->route('planning')->with('SuccessSavePlanning', 'Cronograma establecido para el curso ' . $request->chNameCourse . ' en la semana ' . trim($request->chNumberWeek) . ' de la inteligencia ' . $intelligence->type);
            }else{
                return redirect()->route('planning')->with('SecondarySavePlanning', 'Ya existe un cronograma de ' . $intelligence->type . ' en la semana ' . trim($request->chNumberWeek) . ' para el curso ' . $request->chNameCourse);
            }
        }catch(Exception $ex){
            return redirect()->route('planning')->with('SecondarySavePlanning', 'No es posible establecer el cronograma ahora, comuniquese con el administrador');
        }
    }

    function pdfPlanning(Request $request){
        try{

            //dd($request->all());
            /*

            $request->optionFilter;

            $request->chFilterIntelligence;
            $request->chFilterIntelligenceDateInitial;
            $request->chFilterIntelligenceDateFinal;

            $request->chFilterCourse;
            $request->chFilterCourseDateInitial;
            $request->chFilterCourseDateFinal;

            $request->chFilterCollaborator;
            $request->chFilterCollaboratorDateInitial;
            $request->chFilterCollaboratorDateFinal;

            */

            if($request->optionFilter == 'INTELLIGENCE'){
                //DESCARGAR EL CRONOGRAMA QUE TENGA QUE VER CON LA INTELIGENCIA SELECCIONADA

                $intelligence = Intelligence::find(trim($request->chFilterIntelligence));
                $dateInitial = trim($request->chFilterIntelligenceDateInitial);
                $dateFinal = trim($request->chFilterIntelligenceDateFinal);

                $resultFilter = Chronological::select(
                                    'chronologicals.*',
                                    'academicperiods.*',
                                    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator"),
                                    'courses.name AS nameCourse'
                                    )
                                    ->join('academicperiods','academicperiods.apId','chronologicals.chAcademicperiod_id')
                                    ->join('collaborators','collaborators.id','chronologicals.chCollaborator_id')
                                    ->join('courses','courses.id','academicperiods.apCourse_id')
                                    ->where('chIntelligence_id',trim($request->chFilterIntelligence))
                                    ->get();
                $namefile = 'CRONOGRAMA_INTELIGENCIA_' . $intelligence->type . '.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadview('modules.programming.filterPdf.filterIntelligencePdf', compact('intelligence','dateInitial','dateFinal','resultFilter'));
                $pdf->setPaper("letter", "landscape");
                return $pdf->download($namefile);
                //return redirect()->route('planning')->with('SuccessFilterPlanning', 'Cronograma de inteligencia ' . $intelligence->type . ', descargado correctamente');
            }else if($request->optionFilter == 'COURSE'){
                //DESCARGAR EL CRONOGRAMA QUE TENGA QUE VER CON LA CURSO SELECCIONADO
                $course = Course::select(
                            'courses.name AS nameCourse',
                            'grades.name AS nameGrade'
                        )
                        ->join('grades','grades.id','courses.grade_id')
                        ->where('courses.id',trim($request->chFilterCourse))
                        ->first();
                $resultFilter = Chronological::select(
                                    'chronologicals.*',
                                    'academicperiods.*',
                                    'intelligences.type AS typeIntelligence',
                                    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                                    )
                                    ->join('academicperiods','academicperiods.apId','chronologicals.chAcademicperiod_id')
                                    ->join('intelligences','intelligences.id','chronologicals.chIntelligence_id')
                                    ->join('collaborators','collaborators.id','chronologicals.chCollaborator_id')
                                    ->join('courses','courses.id','academicperiods.apCourse_id')
                                    ->where('courses.id',trim($request->chFilterCourse))
                                    ->get();
                $namefile = $course->nameCourse . '_CURSO_CRONOGRAMA.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadview('modules.programming.filterPdf.filterCoursePdf', compact('resultFilter','course'));
                $pdf->setPaper("letter", "landscape");
                return $pdf->download($namefile);
                //return redirect()->route('planning')->with('SuccessFilterPlanning', 'Cronograma de curso ' . $course->name . ', descargado correctamente');
            }else if($request->optionFilter == 'COLLABORATOR'){
                //DESCARGAR EL CRONOGRAMA QUE TENGA QUE VER CON EL DOCENTE SELECCIONADO
                $collaborator = Collaborator::select(
                                DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                            )->where('id',trim($request->chFilterCollaborator))->first();
                $resultFilter = Chronological::select(
                                    'chronologicals.*',
                                    'academicperiods.*',
                                    'intelligences.type AS typeIntelligence',
                                    'courses.name AS nameCourse'
                                    )
                                    ->join('academicperiods','academicperiods.apId','chronologicals.chAcademicperiod_id')
                                    ->join('intelligences','intelligences.id','chronologicals.chIntelligence_id')
                                    ->join('collaborators','collaborators.id','chronologicals.chCollaborator_id')
                                    ->join('courses','courses.id','academicperiods.apCourse_id')
                                    ->where('collaborators.id',trim($request->chFilterCollaborator))
                                    ->get();
                $namefile = 'CRONOGRAMA_DOCENTE_' . $collaborator->nameCollaborator . '.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadview('modules.programming.filterPdf.filterCollaboratorPdf', compact('collaborator','resultFilter'));
                $pdf->setPaper("letter", "landscape");
                return $pdf->download($namefile);
                //return redirect()->route('planning')->with('SuccessFilterPlanning', 'Cronograma de docente ' . $collaborator->firstname . $collaborator->secondname . $collaborator->threename . $collaborator->fourname . ', descargado correctamente');
            }

            
            
        }catch(Exception $ex){
            return redirect()->route('planning')->with('SecondaryFilterPlanning', 'No es posible establecer el cronograma ahora, comuniquese con el administrador');
        }
    }
}
