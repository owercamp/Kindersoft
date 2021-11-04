<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Grade;

class PeriodsController extends Controller
{
    function index(){
        $periods = Period::orderBy('id', 'DESC')->paginate();
        $grades = Grade::all();
        $gradesFilter = Period::select('periods.id','periods.name', 'grades.name as nameGrade','periods.initialDate','periods.finalDate')
                ->join('grades', 'periods.grade_id', '=', 'grades.id')
                ->get();
        return view('modules.periods.index', compact('periods','grades','gradesFilter'));
    }

    function editPeriod($id){
        $period = Period::find($id);
        $grades = Grade::all();
        return view('modules.periods.edit', compact('period','grades'));
    }

    function updatePeriod(Request $request, $id){
        try{
            $period = Period::find($id);
            $period->name = strtoupper($request->name);
            $period->grade_id = strtoupper($request->grade_id);
            $period->initialDate = $request->initialDate;
            $period->finalDate = $request->finalDate;
            $period->save();
            return redirect()->route('periods')->with('PrimaryUpdatePeriod', 'Registro: ' . strtoupper($request->name) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('periods')->with('SecondaryUpdatePeriod', 'Error!!, No fue posible actualizar el periodo');
        }
    }

    function deletePeriod($id){
        try{
            $period = Period::find($id);
            $nameperiod = $period->name;
            $period->delete();
            return redirect()->route('periods')->with('WarningDeletePeriod', 'Registro: ' . $nameperiod . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('periods')->with('SecondaryDeletePeriod', 'Error!!, No fue posible eliminar el periodo');
        }
    }

    function newPeriod(Request $request){
        try{
            Period::firstOrCreate([
                    'name' => $request->name , 
                    'grade_id' => $request->grade_id
                ],[
                    'name' => $request->name,
                    'grade_id' => $request->grade_id,
                    'initialDate' => $request->initialDate,
                    'finalDate' => $request->finalDate
                ]
            );
            return redirect()->route('periods')->with('SuccessSavePeriod', 'Registro: ' . $request->name . ', creado correctamente');
        }catch(Exception $ex){
            return redirect()->route('periods')->with('SecondarySavePeriod', 'Error!! No es posible crear el periodo');
        }
    }
}
