<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Models\Extracurricular;

class ExtracurricularsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $extracurriculars = Extracurricular::all();
        return view('modules.extracurriculars.index', compact('extracurriculars'));
    }

    function editExtracurricular($id){ 
        $extracurricular = Extracurricular::find($id);
        return view('modules.extracurriculars.edit', compact('extracurricular')); 
    }

    function updateExtracurricular(Request $request, $id){
        try{
            $extracurricularUpdate = Extracurricular::where('extConcept', trim(ucfirst(strtolower($request->extConcept))))
                                ->where('extIntensity', trim(strtoupper($request->extIntensity)))
                                ->where('extValue', trim($request->extValue))
                                ->first();
            if($extracurricularUpdate == null){
                $extracurricular = Extracurricular::find($id);
                $extracurricular->extConcept = trim(ucfirst(strtolower($request->extConcept)));
                $extracurricular->extIntensity = trim(strtoupper($request->extIntensity));
                $extracurricular->extValue = trim($request->extValue);
                $extracurricular->save();
                return redirect()->route('extracurriculars')->with('PrimaryUpdateExtracurricular', 'Registro: ' . ucfirst(strtolower($request->extConcept)) . ', actualizado correctamente');
            }else{
                 return redirect()->route('extracurriculars')->with('SecondarySaveExtracurricular', 'Registro NO ACTUALIZADO, Ya existe un registro ' . ucfirst(strtolower($request->extConcept)));
            }
        }catch(Exception $ex){
            return redirect()->route('extracurriculars')->with('SecondaryUpdateExtracurricular', 'Error!!, No es posible actualizar el concepto de extracurricular');
        }
    }

    function deleteExtracurricular($id){
        try{
            $extracurricular = Extracurricular::find($id);
            $nameextracurricular = $extracurricular->extConcept;
            $extracurricular->delete();
            return redirect()->route('extracurriculars')->with('WarningDeleteExtracurricular', 'Registro: ' . $nameextracurricular . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('extracurriculars')->with('SecondaryDeleteExtracurricular', 'Error!!, No es posible eliminar el concepto de extracurricular');
        }
    }

    function newExtracurricular(Request $request){
        try{
            $extracurricularSave = Extracurricular::where('extConcept', trim(ucfirst(strtolower($request->extConcept))))->where('extIntensity', trim(strtoupper($request->extIntensity)))->first();
            if($extracurricularSave == null){
                Extracurricular::create([
                    'extConcept' => trim(ucfirst(strtolower($request->extConcept))),
                    'extIntensity' => trim(strtoupper($request->extIntensity)),
                    'extValue' => trim($request->extValue),
                ]);
                return redirect()->route('extracurriculars')->with('SuccessSaveExtracurricular', 'Registro: ' . ucfirst(strtolower($request->extConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('extracurriculars')->with('SecondarySaveExtracurricular', 'Ya existe un registro ' . ucfirst(strtolower($request->extConcept)));
            }
            /* Extracurricular::firstOrCreate([
                    'extConcept' => ucfirst(strtolower($request->extConcept)),
                ],[
                    'extConcept' => ucfirst(strtolower($request->extConcept)),
                    'extIntensity' => $request->extIntensity,
                    'extValue' => $request->extValue,
                ]
            );
            return redirect()->route('extracurriculars')->with('SuccessSaveExtracurricular', 'Registro: ' . ucfirst(strtolower($request->extConcept)). ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('extracurriculars')->with('SecondarySaveExtracurricular', 'Error!!, No es posible crear el concepto de extracurricular');
        }
    }
}
