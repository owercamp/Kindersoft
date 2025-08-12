<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $admissions = Admission::all();
        return view('modules.admissions.index', compact('admissions'));
    }

    function editAdmission($id){ 
        $admission = Admission::find($id);
        return view('modules.admissions.edit', compact('admission')); 
    }

    function updateAdmission(Request $request, $id){
        try{
            $admissionUpdate = Admission::where('admConcept', trim(strtoupper($request->admConcept)))
            ->where('admValue', trim($request->admValue))
            ->first();
            if($admissionUpdate == null){
                $admission = Admission::find($id);
                $admission->admConcept = trim(ucfirst(strtolower($request->admConcept)));
                $admission->admValue = trim($request->admValue);
                $admission->save();
                return redirect()->route('admissions')->with('PrimaryUpdateAdmission', 'Registro: ' . ucfirst(strtolower($request->admConcept)) . ', actualizado correctamente');
            }else{
                return redirect()->route('admissions')->with('SecondaryUpdateAdmission', 'Registro: ' . ucfirst(strtolower($request->admConcept)) . ', NO ACTUALIZADO, Ya existe un registro con el concepto de admisión y el valor indicado');
            }
        }catch(Exception $ex){
            return redirect()->route('admissions')->with('SecondaryUpdateAdmission', 'Error!!, No es posible actualizar la admisión');
        }
    }

    function deleteAdmission($id){
        try{
            $admission = Admission::find($id);
            $nameadmission = $admission->admConcept;
            $admission->delete();
            return redirect()->route('admissions')->with('WarningDeleteAdmission', 'Registro: ' . $nameadmission . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('admissions')->with('SecondaryDeleteAdmission', 'Error!!, No es posible eliminar la admisión');
        }
    }

    function newAdmission(Request $request){
        try{
            $admissionSave = Admission::where('admConcept', trim(strtoupper($request->admConcept)))->first();
            if($admissionSave == null){
                Admission::create([
                    'admConcept' => trim(ucfirst(strtolower($request->admConcept))),
                    'admValue' => trim($request->admValue),
                ]);
                return redirect()->route('admissions')->with('SuccessSaveAdmission', 'Registro: ' . ucfirst(strtolower($request->admConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('admissions')->with('SecondarySaveAdmission', 'Ya existe un registro ' . ucfirst(strtolower($request->admConcept)));
            }
        }catch(Exception $ex){
            return redirect()->route('admissions')->with('SecondarySaveAdmission', 'Error!!, No es posible crear la admisión');
        }
    }
}
