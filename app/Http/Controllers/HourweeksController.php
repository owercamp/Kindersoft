<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Course;

use App\Models\Hourweek;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use App\Models\ActivityClass;
use App\Models\ActivitySpace;
use App\Models\CourseConsolidated;
use Illuminate\Support\Facades\DB;

class HourweeksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function hoursWeekTo(){
        $activityclass = ActivityClass::all();
        $activityspace = ActivitySpace::all();
        $collaborators = Collaborator::select('id', DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator"))->get();
        $courses = CourseConsolidated::select('courses.*')->join('courses','courses.id','coursesconsolidated.ccCourse_id')->get();
        return view('modules.programming.hoursweek', compact('courses','activityclass','activityspace','collaborators'));
    }

    function deleteHoursWeek(Request $request){
        try{
            $hourweekToDelete = Hourweek::find($request->hwIdDelete);
            $course = Course::find($hourweekToDelete->hwCourse_id);
            $collaborator = Collaborator::find($hourweekToDelete->hwCollaborator_id);
            $name = 'Actividad para el curso ' . $course->name . ' con el colaborador ' . $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname;
            $hourweekToDelete->delete();
            return redirect()->route('hoursweek')->with('WarningDeleteHoursweek', $name . ', Eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('hoursweek')->with('SecondaryDeleteHoursweek', 'No es posible eliminar la programación ahora, Comuníquese con el administrador');
        }
    }

    function pdfHoursWeek(Request $request){
    	try{
            // dd($request->all());
            /*
            $request->optionFilter;
            $request->hwFilterActivitySpace;
            $request->hwFilterActivityOnly;
            $request->hwFilterCourse;
            $request->hwFilterCollaborator;
            $request->hwFilterHour;
            $request->hwFilterDay;
            */
            $dateNow = date('Y') . '-' . date('m') . '-' . date("d");
            $hourNow = date("H") . ':' . date("i") . ':' . date("s"); //Hora formato de 24 horas de 00 a 23

            if($request->optionFilter == 'SPACE'){
                //DESCARGAR EL HORARIO QUE TENGA QUE VER CON EL ESPACIO SELECCIONADO
                $resultFilter = Hourweek::select(
                    'hoursweek.*',
                    'activityspaces.*',
                    'activityclass.*',
                    'courses.name',
                    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                                    )
                                    ->join('activityspaces','activityspaces.asId','hoursweek.hwActivitySpace_id')
                                    ->join('activityclass','activityclass.acId','hoursweek.hwActivityClass_id')
                                    ->join('courses','courses.id','hoursweek.hwCourse_id')
                                    ->join('collaborators','collaborators.id','hoursweek.hwCollaborator_id')
                                    ->where('hwActivitySpace_id',trim($request->hwFilterActivitySpace))
                                    ->where('hwDate','>=',$dateNow)
                                    ->orderBy('hwDate')->get();
                $activityspace = ActivitySpace::find(trim($request->hwFilterActivitySpace));
                $namefile = $activityspace->asSpace . '_ESPACIO_HORARIO.pdf';
                $pdf = \App::make('dompdf.wrapper');
                //
                // $options = new Options();
                // $options->set('isJavascriptEnabled', TRUE);
                // $dompdf = new Dompdf($options);
                // $dompdf->load_html($HTML);
                // $dompdf->setPaper('A4', 'portrait');
                // $dompdf->render();
                // $dompdf->stream('blah.pdf');
                //$pdf->setOptions(['isJavascriptEnabled' => true]);
                //$pdf->setOptions(['DOMPDF_ENABLE_JAVASCRIPT' => true]);
                //def("DOMPDF_ENABLE_JAVASCRIPT", true);
                $pdf->loadview('modules.programming.filterPdf.filterSpacePdf', compact('resultFilter','activityspace'));
                return $pdf->download($namefile);
                //return redirect()->route('planning')->with('SuccessFilterPlanning', 'Cronograma de inteligencia ' . $intelligence->type . ', descargado correctamente');
            }else if($request->optionFilter == 'ACTIVITY'){
                //DESCARGAR EL HORARIO QUE TENGA QUE VER CON EL ESPACIO SELECCIONADO
                $resultFilter = Hourweek::select(
                    'hoursweek.*',
                    'activityspaces.*',
                    'activityclass.*',
                    'courses.name',
                    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                                    )
                                    ->join('activityspaces','activityspaces.asId','hoursweek.hwActivitySpace_id')
                                    ->join('activityclass','activityclass.acId','hoursweek.hwActivityClass_id')
                                    ->join('courses','courses.id','hoursweek.hwCourse_id')
                                    ->join('collaborators','collaborators.id','hoursweek.hwCollaborator_id')
                                    ->where('hwActivityClass_id',trim($request->hwFilterActivityOnly))
                                    ->where('hwDate','>=',$dateNow)
                                    ->orderBy('hwDate')->get();
                $activityclass = ActivityClass::find(trim($request->hwFilterActivityOnly));
                $namefile = $activityclass->acClass . '_ACTIVIDAD_HORARIO.pdf';
                $pdf = \App::make('dompdf.wrapper');
                //
                // $options = new Options();
                // $options->set('isJavascriptEnabled', TRUE);
                // $dompdf = new Dompdf($options);
                // $dompdf->load_html($HTML);
                // $dompdf->setPaper('A4', 'portrait');
                // $dompdf->render();
                // $dompdf->stream('blah.pdf');
                //$pdf->setOptions(['isJavascriptEnabled' => true]);
                //$pdf->setOptions(['DOMPDF_ENABLE_JAVASCRIPT' => true]);
                //def("DOMPDF_ENABLE_JAVASCRIPT", true);
                $pdf->loadview('modules.programming.filterPdf.filterClassPdf', compact('resultFilter','activityclass'));
                return $pdf->download($namefile);
                //return redirect()->route('planning')->with('SuccessFilterPlanning', 'Cronograma de inteligencia ' . $intelligence->type . ', descargado correctamente');
            }else if($request->optionFilter == 'COURSE'){
                //DESCARGAR EL HORARIO QUE TENGA QUE VER CON EL ESPACIO SELECCIONADO
                $resultFilter = Hourweek::select(
                    'hoursweek.*',
                    'activityspaces.*',
                    'activityclass.*',
                    'courses.name',
                    DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                                    )
                                    ->join('activityspaces','activityspaces.asId','hoursweek.hwActivitySpace_id')
                                    ->join('activityclass','activityclass.acId','hoursweek.hwActivityClass_id')
                                    ->join('courses','courses.id','hoursweek.hwCourse_id')
                                    ->join('collaborators','collaborators.id','hoursweek.hwCollaborator_id')
                                    ->where('hwCourse_id',trim($request->hwFilterCourse))
                                    ->where('hwDate','>=',$dateNow)
                                    ->orderBy('hwDate')->get();
                $course = Course::select('courses.name as nameCourse','grades.name as nameGrade')
                                        ->join('grades','grades.id','courses.grade_id')
                                        ->where('courses.id',trim($request->hwFilterCourse))
                                        ->first();
                $namefile = $course->nameCourse . '_CURSO_HORARIO.pdf';
                $pdf = \App::make('dompdf.wrapper');
                //
                // $options = new Options();
                // $options->set('isJavascriptEnabled', TRUE);
                // $dompdf = new Dompdf($options);
                // $dompdf->load_html($HTML);
                // $dompdf->setPaper('A4', 'portrait');
                // $dompdf->render();
                // $dompdf->stream('blah.pdf');
                //$pdf->setOptions(['isJavascriptEnabled' => true]);
                //$pdf->setOptions(['DOMPDF_ENABLE_JAVASCRIPT' => true]);
                //def("DOMPDF_ENABLE_JAVASCRIPT", true);
                $pdf->loadview('modules.programming.filterPdf.filterCoursePdf', compact('resultFilter','course'));
                return $pdf->download($namefile);
                //return redirect()->route('planning')->with('SuccessFilterPlanning', 'Cronograma de inteligencia ' . $intelligence->type . ', descargado correctamente');
            }else if($request->optionFilter == 'COLLABORATOR'){
                //DESCARGAR EL HORARIO QUE TENGA QUE VER CON EL DOCENTE SELECCIONADO
                $resultFilter = Hourweek::select(
                                    'hoursweek.*',
                                    'activityspaces.*',
                                    'activityclass.*',
                                    'collaborators.*',
                                    'courses.name'
                                    )
                                    ->join('activityspaces','activityspaces.asId','hoursweek.hwActivitySpace_id')
                                    ->join('activityclass','activityclass.acId','hoursweek.hwActivityClass_id')
                                    ->join('courses','courses.id','hoursweek.hwCourse_id')
                                    ->join('collaborators','collaborators.id','hoursweek.hwCollaborator_id')
                                    ->where('hwCollaborator_id',trim($request->hwFilterCollaborator))
                                    ->where('hwDate','>=',$dateNow)
                                    ->orderBy('hwDate')->get();
                $collaborator = Collaborator::select(DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator"))->where('id',trim($request->hwFilterCollaborator))->first();
                $namefile = $collaborator->nameCollaborator . '_DOCENTE_HORARIO.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadview('modules.programming.filterPdf.filterHourweekCollaborator', compact('resultFilter','collaborator'));
                return $pdf->download($namefile);
            }else if($request->optionFilter == 'HOUR'){
                //DESCARGAR EL HORARIO QUE TENGA QUE VER CON LA HORA SELECCIONADA
                $resultFilter = Hourweek::select(
                        'hoursweek.*',
                        'activityspaces.*',
                        'activityclass.*',
                        DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator"),
                        'courses.name'
                        )
                        ->join('activityspaces','activityspaces.asId','hoursweek.hwActivitySpace_id')
                        ->join('activityclass','activityclass.acId','hoursweek.hwActivityClass_id')
                        ->join('courses','courses.id','hoursweek.hwCourse_id')
                        ->join('collaborators','collaborators.id','hoursweek.hwCollaborator_id')
                        ->where('hwHourInitial','>=',trim($request->hwFilterHour))
                        ->where('hwDate','>=',$dateNow)
                        ->orderBy('hwDate')->get();
                $hourSeparated = explode(':',trim($request->hwFilterHour));
                $timeHour = date('A', strtotime(trim($request->hwFilterHour)));
                $hour = date('h', strtotime(trim($request->hwFilterHour))) . ':' . $hourSeparated[1] . ' ' . $timeHour;

                //dd($hour);

                $namefile = trim($request->hwFilterHour) . '_HORAINICIAL_HORARIO.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadview('modules.programming.filterPdf.filterHour', compact('resultFilter','hour'));
                return $pdf->download($namefile);
            }else if($request->optionFilter == 'DAY'){
                //DESCARGAR EL HORARIO QUE TENGA QUE VER CON EL DIA SELECCIONADO
               	$resultFilter = Hourweek::select(
                        'hoursweek.*',
                        'activityspaces.*',
                        'activityclass.*',
                        DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator"),
                        'courses.name'
                        )
                        ->join('activityspaces','activityspaces.asId','hoursweek.hwActivitySpace_id')
                        ->join('activityclass','activityclass.acId','hoursweek.hwActivityClass_id')
                        ->join('courses','courses.id','hoursweek.hwCourse_id')
                        ->join('collaborators','collaborators.id','hoursweek.hwCollaborator_id')
                        ->where('hwDate',trim($request->hwFilterDay))
                        ->orderBy('hwDate')->orderBy('hwHourInitial')->get();
                $dateSelected = trim($request->hwFilterDay);
                $namefile = trim($request->hwFilterDay) . '_FECHA_HORARIO.pdf';
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadview('modules.programming.filterPdf.filterDay', compact('resultFilter','dateSelected'));
                return $pdf->download($namefile);
            }
        }catch(Exception $ex){
           // return redirect()->route('hoursweek')->with('SecondaryFilterHoursweek', 'No es posible descargar ahora, Comuníquese con el administrador');
        }
    }
}
