<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Supplie;
use Illuminate\Http\Request;

class SuppliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $supplies = Supplie::all();
        return view('modules.supplies.index', compact('supplies'));
    }

    function editSupplie($id){ 
        $supplie = Supplie::find($id);
        return view('modules.supplies.edit', compact('supplie')); 
    }

    function updateSupplie(Request $request, $id){
        try{
            $supplieUpdate = Supplie::where('supConcept', trim(ucfirst(strtolower($request->supConcept))))
                            ->where('supValue', trim($request->supValue))
                            ->first();
            if($supplieUpdate == null){
                $supplie = Supplie::find($id);
                $supplie->supConcept = trim(ucfirst(strtolower($request->supConcept)));
                $supplie->supValue = trim($request->supValue);
                $supplie->save();
                return redirect()->route('supplies')->with('PrimaryUpdateSupplie', 'Registro: ' . ucfirst(strtolower($request->supConcept)) . ', actualizado correctamente');
            }else{
                 return redirect()->route('supplies')->with('SecondarySaveSupplie', 'Registro NO ACTUALIZADO, Ya existe un registro ' . ucfirst(strtolower($request->supConcept)));
            }
        }catch(Exception $ex){
            return redirect()->route('supplies')->with('SecondaryUpdateSupplie', 'Error!!, No es posible actualizar el concepto de material escolar');
        }
    }

    function deleteSupplie($id){
        try{
            $supplie = Supplie::find($id);
            $namesupplie = $supplie->supConcept;
            $supplie->delete();
            return redirect()->route('supplies')->with('WarningDeleteSupplie', 'Registro: ' . $namesupplie . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('supplies')->with('SecondaryDeleteSupplie', 'Error!!, No es posible eliminar el concepto de material escolar');
        }
    }

    function newSupplie(Request $request){
        try{
            $supplieSave = Supplie::where('supConcept', trim(ucfirst(strtolower($request->supConcept))))->first();
            if($supplieSave == null){
                Supplie::create([
                    'supConcept' => trim(ucfirst(strtolower($request->supConcept))),
                    'supValue' => trim($request->supValue),
                ]);
                return redirect()->route('supplies')->with('SuccessSaveSupplie', 'Registro: ' . ucfirst(strtolower($request->supConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('supplies')->with('SecondarySaveSupplie', 'Ya existe un registro ' . ucfirst(strtolower($request->supConcept)));
            }
            /* Supplie::firstOrCreate([
                    'supConcept' => ucfirst(strtolower($request->supConcept)),
                ],[
                    'supConcept' => ucfirst(strtolower($request->supConcept)),
                    'supValue' => $request->supValue,
                ]
            );
            return redirect()->route('supplies')->with('SuccessSaveSupplie', 'Registro: ' . ucfirst(strtolower($request->supConcept)). ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('supplies')->with('SecondarySaveSupplie', 'Error!!, No es posible crear el concepto de material escolar');
        }
    }
}
