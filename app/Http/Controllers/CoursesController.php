<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $courses = Course::all();
         $grades = Grade::all();
        return view('modules.courses.index', compact('courses', 'grades'));
    }

    function editCourse($id){ 
        $course = Course::find($id);
        $grades = Grade::all();
        return view('modules.courses.edit', compact('course', 'grades')); 
    }

    function updateCourse(Request $request, $id){
        try{
            $course = Course::find($id);
            $course->name = strtoupper($request->name);
            $course->grade_id = $request->grade_id;
            $course->save();
            return redirect()->route('courses')->with('PrimaryUpdateCourse', 'Registro: ' . strtoupper($request->name) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('courses')->with('SecondaryUpdateCourse', 'Error!!, No es posible actualizar el curso');
        }
    }

    function deleteCourse($id){
        try{
            $course = Course::find($id);
            $namecourse = $course->name;
            $course->delete();
            return redirect()->route('courses')->with('WarningDeleteCourse', 'Registro: ' . $namecourse . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('courses')->with('SecondaryDeleteCourse', 'Error!!, No es posible eliminar el curso');
        }
    }

    function newCourse(Request $request){
        try{
            $courseSave = Course::where('name',strtoupper($request->name))
                            ->where('grade_id',$request->grade_id)
                            ->first();
            if($courseSave == null){
                Course::create([
                    'name' => strtoupper($request->name),
                    'grade_id' => $request->grade_id,
                ]);
                return redirect()->route('courses')->with('SuccessSaveCourse', 'Registro: ' . strtoupper($request->name) . ', creado correctamente');
            }else{
                 return redirect()->route('courses')->with('SecondarySaveCourse', 'Ya existe un registro ' . strtoupper($request->name) . ' para el grado seleccionado');
            }
            /*Course::firstOrCreate([
                    'name' => strtoupper($request->name),
                    'grade_id' => $request->grade_id,
                ],[
                    'name' => strtoupper($request->name),
                    'grade_id' => $request->grade_id,
                ]
            );
            return redirect()->route('courses')->with('SuccessSaveCourse', 'Registro: ' . strtoupper($request->name) . ', creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('courses')->with('SecondarySaveCourse', 'Error!!, No es posible crear el curso');
        }    
    }
}
