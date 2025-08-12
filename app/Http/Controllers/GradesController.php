<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    function index(){
        $grades = Grade::all();
        return view('modules.grades.index', compact('grades'));
    }

    function editGrade($id){ 
        $grade = Grade::find($id);
        return view('modules.grades.edit', compact('grade')); 
    }

    function updateGrade(Request $request, $id){
        try{
            $gradeUpdate = Grade::where('name',strtoupper($request->name))->first();
            if($gradeUpdate == null){
                $grade = Grade::find($id);
                $grade->name = strtoupper($request->name);
                $grade->save();
                return redirect()->route('grades')->with('PrimaryUpdateGrade', 'Registro: ' . strtoupper($request->name) . ', actualizado correctamente');
            }else{
                return redirect()->route('grades')->with('SecondarySaveGrade', 'Registro ' . strtoupper($request->name) . ' NO ACTUALIZADO, Ya existe un registro con el nombre');
            }
        }catch(Exception $ex){
            return redirect()->route('grades')->with('SecondaryUpdateGrade', 'Error!!, No es posible actualizar el grado');
        }
    }

    function deleteGrade($id){
        try{
            //Eliminación en cascada de los grados con sus cursos
            // 1.) Buscar el grado con su ID;
            $grade = Grade::find($id);
            // 2.) Guardar nombre para mensaje final
            $namegrade = $grade->name;
            // 3.) Buscar los cursos relacionadas con el grado
            $courses = Course::where('grade_id', $grade->id)->get();
            // 4.) Recorrer los cursos relacionados con el grado y eliminarlos
            foreach ($courses as $course){
                Course::where('id',$course->id)->delete();
            }
            // 5.) Eliminar el grado
            $grade->delete();
            return redirect()->route('grades')->with('WarningDeleteGrade', 'Registro: ' . $namegrade . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('grades')->with('SecondaryDeleteGrade', 'Error!!, No es posible eliminar el grado');
        }
    }

    function newGrade(Request $request){
        try{
            $gradeSave = Grade::where('name',strtoupper($request->name))->first();
            if($gradeSave == null){
                Grade::create([
                    'name' => strtoupper($request->name),
                ]);
                return redirect()->route('grades')->with('SuccessSaveGrade', 'Registro: ' . strtoupper($request->name) . ', creado correctamente');
            }else{
                 return redirect()->route('grades')->with('SecondarySaveGrade', 'Ya existe un registro ' . strtoupper($request->name));
            }
            /*Grade::firstOrCreate([
                    'name' => strtoupper($request->name),
                ],[
                    'name' => strtoupper($request->name),
                ]
            );
            return redirect()->route('grades')->with('SuccessSaveGrade', 'Registro: ' . strtoupper($request->name) . ', creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('grades')->with('SecondarySaveGrade', 'Error!!, No es posible crear el grado');
        }
    }
}
