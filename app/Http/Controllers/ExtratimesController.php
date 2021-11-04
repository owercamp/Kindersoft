<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Extratime;

class ExtratimesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $extratimes = Extratime::all();
        return view('modules.extratimes.index', compact('extratimes'));
    }

    function editExtratime($id){ 
        $extratime = Extratime::find($id);
        return view('modules.extratimes.edit', compact('extratime')); 
    }

    function updateExtratime(Request $request, $id){
        try{
            $extratimeUpdate = Extratime::where('extTConcept', trim(ucfirst(strtolower($request->extTConcept))))
                            ->where('extTValue', trim($request->extTValue))
                            ->first();
            if($extratimeUpdate == null){
                $extratime = Extratime::find($id);
                $extratime->extTConcept = trim(ucfirst(strtolower($request->extTConcept)));
                $extratime->extTValue = trim($request->extTValue);
                $extratime->save();
                return redirect()->route('extratimes')->with('PrimaryUpdateExtratime', 'Registro: ' . ucfirst(strtolower($request->extTConcept)) . ', actualizado correctamente');
            }else{
                 return redirect()->route('extratimes')->with('SecondarySaveExtratime', 'Registro NO ACTUALIZADO, Ya existe un registro ' . ucfirst(strtolower($request->extTConcept)));
            }
        }catch(Exception $ex){
            return redirect()->route('extratimes')->with('SecondaryUpdateExtratime', 'Error!!, No es posible actualizar el concepto de tiempo extra');
        }
    }

    function deleteExtratime($id){
        try{
            $extratime = Extratime::find($id);
            $nameextratime = $extratime->extTConcept;
            $extratime->delete();
            return redirect()->route('extratimes')->with('WarningDeleteExtratime', 'Registro: ' . $nameextratime . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('extratimes')->with('SecondaryDeleteExtratime', 'Error!!, No es posible eliminar el concepto de tiempo extra');
        }
    }

    function newExtratime(Request $request){
        try{
            $extratimeSave = Extratime::where('extTConcept', trim(ucfirst(strtolower($request->extTConcept))))->first();
            if($extratimeSave == null){
                Extratime::create([
                    'extTConcept' => trim(ucfirst(strtolower($request->extTConcept))),
                    'extTValue' => trim($request->extTValue),
                ]);
                return redirect()->route('extratimes')->with('SuccessSaveExtratime', 'Registro: ' . ucfirst(strtolower($request->extTConcept)). ', creado correctamente');
            }else{
                 return redirect()->route('extratimes')->with('SecondarySaveExtratime', 'Ya existe un registro ' . ucfirst(strtolower($request->extTConcept)));
            }
            /* Extratime::firstOrCreate([
                    'extTConcept' => ucfirst(strtolower($request->extTConcept)),
                ],[
                    'extTConcept' => ucfirst(strtolower($request->extTConcept)),
                    'extTValue' => $request->extTValue,
                ]
            );
            return redirect()->route('extratimes')->with('SuccessSaveExtratime', 'Registro: ' . ucfirst(strtolower($request->extTConcept)). ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('extratimes')->with('SecondarySaveExtratime', 'Error!!, No es posible crear el concepto de tiempo extra');
        }
    }
}
