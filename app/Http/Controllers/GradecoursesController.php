<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Grade;

use App\Models\Course;
use App\Models\Student;
use App\Models\Bulletin;
use App\Models\Hourweek;
use App\Models\Obserbull;
use App\Models\Listcourse;
use App\Models\Achievement;
use App\Models\Observation;
use App\Models\Collaborator;
use App\Models\Intelligence;

use Illuminate\Http\Request;
use App\Models\ActivityClass;
use App\Models\ActivitySpace;
use App\Models\Chronological;

use App\Models\Academicperiod;
use App\Models\Weeklytracking;
use App\Models\CourseConsolidated;
use Illuminate\Support\Facades\DB;
use App\Models\Trackingachievement;

class GradecoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function gradeCourseTo(){
        $grades = Grade::all();
        $collaborators = Collaborator::all();
        return view('modules.structure.gradeCourse', compact('grades', 'collaborators'));
    }

    function newGradeCourse(Request $request){
        try{
            $courseValidate = CourseConsolidated::where('ccCourse_id',trim($request->ccCourse))
                                                //->whereBetween('ccDateInitial',array(trim($request->ccDateInitial),trim($request->ccDateFinal)))
                                                //->where('ccDateFinal','<=',trim($request->ccDateFinal))
                                                ->where('ccStatus','ACTIVO')
                                                ->first();
            if($courseValidate == null){
                CourseConsolidated::create([
                    'ccGrade_id' => trim($request->ccGrade),
                    'ccCourse_id' => trim($request->ccCourse),
                    'ccCollaborator_id' => trim($request->ccCollaborator),
                    'ccDateInitial' => trim($request->ccDateInitial),
                    'ccDateFinal' => trim($request->ccDateFinal)
                ]);
                return redirect()->route('gradeCourse')->with('SuccessSaveGradecourse', 'Curso establecido con el director de curso correctamente, consulta en VER LISTADOS');
            }else{
                $collaborator = Collaborator::find(trim($courseValidate->ccCollaborator_id));
                $course = Course::find(trim($request->ccCourse));
                if($courseValidate->ccCollaborator_id == trim($request->ccCollaborator)){
                    return redirect()->route('gradeCourse')->with('SecondarySaveGradecourse', 'Ya existe un curso ' . $course->name . ' establecido en estado ' . $courseValidate->ccStatus . ' con el mismo director de grupo ' . $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname . ' valide la informacion en VER LISTADOS');
                }else{
                    return redirect()->route('gradeCourse')->with('SecondarySaveGradecourse', 'Ya existe un curso ' . $course->name . ' establecido en estado ' . $courseValidate->ccStatus . ' con el director de grupo ' . $collaborator->firstname . ' ' . $collaborator->threename . ' ' . $collaborator->fourname . ' valide la informacion en VER LISTADOS');
                }
                // $courseValidateCollaborator = CourseConsolidated::where('ccCollaborator_id',trim($request->ccCollaborator))
                //                                 ->where('ccCourse_id',trim($request->ccCourse))
                //                                 //->whereBetween('ccDateInitial',array(trim($request->ccDateInitial),trim($request->ccDateFinal)))
                //                                 //->where('ccDateFinal','<=',trim($request->ccDateFinal))
                //                                 ->where('ccStatus','ACTIVO')
                //                                 ->first();
            }
        }catch(Exception $ex){
            return redirect()->route('gradeCourse')->with('SecondarySaveGradecourse', 'No es posible establecer el curso ahora, comuniquese con el administrador');
        }
    }

    function editGradeCourse(Request $request){
        $courseConsolidated = CourseConsolidated::select(
                'coursesconsolidated.*',
                'grades.name AS nameGrade',
                'courses.name AS nameCourse'
                )
                ->join('grades','grades.id','coursesconsolidated.ccGrade_id')
                ->join('courses','courses.id','coursesconsolidated.ccCourse_id')
                ->where('ccId',$request->ccId)->first();
        $collaborators = Collaborator::all();
        return view('modules.structure.editCourseConsolidated', compact('courseConsolidated','collaborators'));
    }

    function updateGradeCourse(Request $request){
        try{   
            //dd($request->all());
            $courseConsolidatedValidate = CourseConsolidated::where('ccCollaborator_id',trim($request->ccCollaboratorEdit))
                                        ->where('ccId','!=',trim($request->ccIdEdit))
                                        ->first();
            if($courseConsolidatedValidate == null){
                $courseToUpdate =  CourseConsolidated::find(trim($request->ccIdEdit));
                $courseToUpdate->ccGrade_id = trim($request->ccGradeEdit);
                $courseToUpdate->ccCourse_id = trim($request->ccCourseEdit);
                $courseToUpdate->ccCollaborator_id = trim($request->ccCollaboratorEdit);
                $courseToUpdate->ccDateInitial = trim($request->ccDateInitialEdit);
                $courseToUpdate->ccDateFinal = trim($request->ccDateFinalEdit);
                $courseToUpdate->ccStatus = trim($request->ccStatusEdit);
                $courseToUpdate->save();
                return redirect()->route('listgradeCourse')->with('PrimarySaveCourseConsolidated', 'Se han guardado los cambios correctamente');
            }else{
                return redirect()->route('listgradeCourse')->with('PrimarySaveCourseConsolidated', 'Ya existe un curso para el director de grupo seleccionado');
            }
        }catch(Exception $ex){
            
        }
    }

    function listGradeCourseTo(){
        $coursesConsolidated = CourseConsolidated::select(
                        'coursesconsolidated.*',
                        'grades.id AS idGrade',
                        'grades.name as nameGrade',
                        'courses.id AS idCourse',
                        'courses.name AS nameCourse',
                        DB::raw("CONCAT(collaborators.firstname,' ',collaborators.threename,' ',collaborators.fourname) AS nameCollaborator")
                    )
                    ->join('grades','grades.id','coursesconsolidated.ccGrade_id')
                    ->join('courses','courses.id','coursesconsolidated.ccCourse_id')
                    ->join('collaborators','collaborators.id','coursesconsolidated.ccCollaborator_id')
                    ->get();
        $counts = array();
        $index = 0;
        $grades = Grade::all();
        foreach ($coursesConsolidated as $course){
            $counts[$index] = Listcourse::where('listGrade_id',$course->idGrade)->where('listCourse_id',$course->idCourse)->count();
            $index++;
        }
        return view('modules.structure.listGradeCourse', compact('coursesConsolidated','counts','grades'));
    }

    function listGradeCoursePdf(Request $request){
        try{
            if(isset($request->ccId)){
                $courseconsolidated = CourseConsolidated::find($request->ccId);

                $collaborator = Collaborator::find($courseconsolidated->ccCollaborator_id);
                $grade = Grade::find($courseconsolidated->ccGrade_id);
                $course = Course::find($courseconsolidated->ccCourse_id);
                $listStudent = Listcourse::select('listStudent_id')->where('listGrade_id',$courseconsolidated->ccGrade_id)->where('listCourse_id',$courseconsolidated->ccCourse_id)->get();
                $students = array();
                $index = 0;
                foreach ($listStudent as $list) {
                    $studentAll = Student::find($list->listStudent_id);
                    if($studentAll != null){
                        for ($i=0; $i <= 6; $i++) { 
                            //ITERAR CADA COLUMNA DE LA TABLA ESTUDIANTES PARA ASIGNAR DATOS AL ARREGLO
                            if($i == 0){ $students[$index][$i] = $studentAll->id; }//ID DEL ESTUDIANTE
                            else if($i == 1){ $students[$index][$i] = $studentAll->typedocument_id; }
                            else if($i == 2){ $students[$index][$i] = $studentAll->numberdocument; }
                            else if($i == 3){ $students[$index][$i] = $studentAll->firstname; }
                            else if($i == 4){ $students[$index][$i] = $studentAll->threename . ' ' . $studentAll->fourname; }
                            else if($i == 5){ $students[$index][$i] = $studentAll->yearsold; }
                            else if($i == 6){ $students[$index][$i] = $studentAll->birthdate; }
                        }
                        $index++;
                    }
                }
                if($students !== null && $collaborator !== null && $grade !== null && $course !== null){
                    $namefile = $course->name . '_LISTADO_DE_ALUMNOS.pdf';
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadview('modules.structure.listGradeCoursePdf', compact('students','collaborator','grade','course'));
                    return $pdf->download($namefile);
                }
                return redirect()->route('gradeCourse')->with('SuccessExport', 'Listado descargado correctamente');
            }
        }catch(Exception $ex){
            return redirect()->route('gradeCourse')->with('SecondaryExport', 'No fue posible exportar a PDF, comuniquese con el administrador');
        }
    }

    function changeReload(Request $request){
        try{
            if($request->all()){
                return redirect()->route('listgradeCourse')->with('PrimarySaveCourseConsolidated', 'SE HAN GUARDADO LOS CAMBIOS EN LOS CURSOS');
            }else{
                return redirect()->route('listgradeCourse')->with('PrimarySaveCourseConsolidated', 'SE HAN GUARDADO LOS CAMBIOS EN LOS CURSOS');
            }
        }catch(Exception $ex){
            // Code exception
        }
    }
}
