<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Health;
use Illuminate\Http\Request;

class HealthsController extends Controller
{
    function index(){

        $healths = Health::all();
        return view('modules.healths.index', compact('healths'));
    }

    function editHealth($id){ 
        $health = Health::find($id);
        return view('modules.healths.edit', compact('health')); 
    }

    function updateHealth(Request $request, $id){
        try{
            $health = Health::find($id);
            $health->entity = strtoupper($request->entity);
            $health->type = strtoupper($request->type);
            $health->save();
            return redirect()->route('healths')->with('PrimaryUpdateHealth', 'Registro: ' . strtoupper($request->entity) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('healths')->with('SecondaryUpdateHealth', 'Error!!, No es posible actualizar el centro de salud');
        }
    }

    function deleteHealth($id){
        try{
            $health = Health::find($id);
            $namehealth = $health->entity;
            $health->delete();
            return redirect()->route('healths')->with('WarningDeleteHealth', 'Registro: ' . $namehealth . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('healths')->with('SecondaryDeleteHealth', 'Error!!, No es posible eliminar el centro de salud');
        }
    }

    function newHealth(Request $request){
        try{
            $healthSave = Health::where('entity',strtoupper($request->entity))
                            ->where('type',strtoupper($request->type))
                            ->first();
            if($healthSave == null){
                Health::create([
                    'entity' => strtoupper($request->entity),
                    'type' => strtoupper($request->type),
                ]);
                return redirect()->route('healths')->with('SuccessSaveHealth', 'Registro: ' . strtoupper($request->entity) . ', creado correctamente');
            }else{
                 return redirect()->route('healths')->with('SecondarySaveHealth', 'Ya existe un registro ' . strtoupper($request->entity) . ' con el tipo de afiliación seleccionado');
            }
            /*Health::firstOrCreate([
                    'entity' => strtoupper($request->entity),
                    'type' => strtoupper($request->type),
                ],[
                    'entity' => strtoupper($request->entity),
                    'type' => strtoupper($request->type),
                ]
            );
            return redirect()->route('healths')->with('SuccessSaveHealth', 'Registro: ' . strtoupper($request->entity) . ', creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('healths')->with('SecondarySaveHealth', 'Error!!, No es posible crear el centro de salud');
        }
    }
}
