<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Intelligence;
use App\Models\Achievement;

class IntelligencesController extends Controller
{
    function index(){
        $intelligences = Intelligence::all();
        return view('modules.intelligences.index', compact('intelligences'));
    }

    function editIntelligence($id){ 
        $intelligence = Intelligence::find($id);
        return view('modules.intelligences.edit', compact('intelligence')); 
    }

    function updateIntelligence(Request $request, $id){
        try{
            $intelligence = Intelligence::find($id);
            $intelligence->type = strtoupper($request->type);
            $intelligence->description = ucfirst(strtolower($request->description));
            $intelligence->save();
            return redirect()->route('intelligences')->with('PrimaryUpdateIntelligence', 'Registro: ' . strtoupper($request->type) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('intelligences')->with('SecondaryUpdateIntelligence', 'Error!!, No es posible actualizar la intelidencia');
        }
    }

    function deleteIntelligence($id){
        try{
            //Eliminación en cascada de las inteligencias con sus logros

            // 1.) Buscar la inteligencia con su ID;
            $intelligence = Intelligence::find($id);
            // 2.) Guardar nombre para mensaje final
            $nameintelligence = $intelligence->type;
            // 3.) Buscar los logros relacionadas con la inteligencia
            $achievements = Achievement::where('intelligence_id', $intelligence->id)->get();
            // 4.) Recorrer los logros relacionados con la inteligencia y eliminarlos
            foreach ($achievements as $achievement) {
                Achievement::where('id',$achievement->id)->delete();
            }
            // 5.) Eliminar la inteligencia
            $intelligence->delete();
            return redirect()->route('intelligences')->with('WarningDeleteIntelligence', 'Registro: ' . $nameintelligence . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('intelligences')->with('SecondaryDeleteIntelligence', 'Error!!, No es posible eliminar la inteligencia');
        }
    }

    function newIntelligence(Request $request){
        try{
            $intelligenceSave = Intelligence::where('type',strtoupper($request->type))->first();
            if($intelligenceSave == null){
                Intelligence::create([
                    'type' => strtoupper($request->type),
                    'description' => ucfirst(strtolower($request->description)),
                ]);
                return redirect()->route('intelligences')->with('SuccessSaveIntelligence', 'Registro: ' . strtoupper($request->type) . ' creado correctamente');
            }else{
                 return redirect()->route('intelligences')->with('SecondarySaveIntelligence', 'Ya existe un registro ' . strtoupper($request->type));
            }
            /*Intelligence::firstOrCreate([
                    'type' => strtoupper($request->type),
                ],[
                    'type' => strtoupper($request->type),
                    'description' => ucfirst(strtolower($request->description)),
                ]
            );
            return redirect()->route('intelligences')->with('SuccessSaveIntelligence', 'Registro: ' . strtoupper($request->type) . ', creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('intelligences')->with('SecondarySaveIntelligence', 'Error!!, No es posible crear la inteligencia');
        }
    }
}
