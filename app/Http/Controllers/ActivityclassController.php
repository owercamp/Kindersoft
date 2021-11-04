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

class ActivityclassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function activityClassTo(){
        $activityClass = ActivityClass::all();
        return view('modules.structure.activityClass', compact('activityClass'));
    }

    function newActivityClass(Request $request){
        try{
            $activityclassValidate = ActivityClass::where('acNumber',$request->acNumber)->orWhere('acClass',$request->acClass)->first();
            if($activityclassValidate == null){
                ActivityClass::create([
                    'acNumber' => trim($request->acNumber),
                    'acClass' => trim(ucfirst(mb_strtolower($request->acClass,'UTF-8'))),
                    'acDescription' => trim(ucfirst(mb_strtolower($request->acDescription,'UTF-8')))
                ]);
                return redirect()->route('activityClass')->with('SuccessSaveActivityClass', 'Registro ' . $request->acClass . ', creado correctamente');
            }else{
                return redirect()->route('activityClass')->with('SecondarySaveActivityClass', 'Ya existe un registro con número ' . $request->acNumber . ' o nombre de clase/actividad ' . $request->acClass);
            }
        }catch(Exception $ex){
            return redirect()->route('activityClass')->with('SecondarySaveActivityClass', 'No es posible crear la clase/actividad ahora, Comuníquese con el administrador');
        }
    }

    function updateActivityClass(Request $request){
        try{
            $activityClassValidate = ActivityClass::where('acId','!=',$request->acIdEdit)
                                                    ->Where('acNumber',trim($request->acNumberEdit))
                                                    ->Where('acClass',trim(ucfirst(mb_strtolower($request->acClassEdit,'UTF-8'))))
                                                    ->first();
            if($activityClassValidate == null){
                $activityToUpdate = ActivityClass::find($request->acIdEdit);
                $activityToUpdate->acNumber = trim($request->acNumberEdit);
                $activityToUpdate->acClass = trim(ucfirst(mb_strtolower($request->acClassEdit,'UTF-8')));
                $activityToUpdate->acDescription = trim(ucfirst(mb_strtolower($request->acDescriptionEdit,'UTF-8')));
                $activityToUpdate->save();
                return redirect()->route('activityClass')->with('PrimaryUpdateActivityClass', 'Registro ' . trim(ucfirst(mb_strtolower($request->acClassEdit,'UTF-8'))) . ', modificado correctamente');
            }else{
                return redirect()->route('activityClass')->with('SecondaryUpdateActivityClass', 'Ya existe una clase/actividad con el número o nombre modificado');
            }
        }catch(Exception $ex){
            return redirect()->route('activityClass')->with('SecondaryUpdateActivityClass', 'No es posible actualizar la clase/actividad ahora, Comuníquese con el administrador');
        }
    }

    function deleteActivityClass(Request $request){
        try{
            $activityToDelete = ActivityClass::find($request->acIdDelete);
            $nameActivity = $activityToDelete->acClass;
            $activityToDelete->delete();
            return redirect()->route('activityClass')->with('WarningDeleteActivityClass', 'Registro ' . $nameActivity . ', Eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('activityClass')->with('SecondaryDeleteActivityClass', 'No es posible eliminar la clase/actividad ahora, Comuníquese con el administrador');
        }
    }
}
