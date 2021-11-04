<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Profession;

class ProfessionsController extends Controller
{
    function index(){
        $professions = Profession::all();
        return view('modules.professions.index', compact('professions'));
    }

    function editProfession($id){ 
        $profession = Profession::find($id);
        return view('modules.professions.edit', compact('profession')); 
    }

    function updateProfession(Request $request, $id){
        try{
            $profession = Profession::find($id);
            $profession->title = strtoupper($request->title);
            $profession->save();
            return redirect()->route('professions')->with('PrimaryUpdateProfession', 'Registro: ' . strtoupper($request->title) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('professions')->with('SecondaryUpdateProfession', 'Error!!, No es posible actualizar la profesión');
        }
            
    }

    function deleteProfession($id){
        try{
            $profession = Profession::find($id);
            $nameprofession = $profession->title;
            $profession->delete();
            return redirect()->route('professions')->with('WarningDeleteProfession', 'Registro: ' . $nameprofession . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('professions')->with('SecondaryDeleteProfession', 'Error!!, No es posible eliminar la profesión');
        }
    }

    function newProfession(Request $request){
        try{
            $professionSave = Profession::where('title',strtoupper($request->title))->first();
            if($professionSave == null){
                Profession::create([
                    'title' => strtoupper($request->title),
                ]);
                return redirect()->route('professions')->with('SuccessSaveProfession', 'Registro: ' . strtoupper($request->title) . ' creado correctamente');
            }else{
                 return redirect()->route('professions')->with('SecondarySaveProfession', 'Ya existe un registro ' . strtoupper($request->title));
            }
            /* Profession::firstOrCreate([
                    'title' => strtoupper($request->title),
                ],[
                    'title' => strtoupper($request->title),
                ]
            );
            return redirect()->route('professions')->with('SuccessSaveProfession', 'Registro: ' . strtoupper($request->title) . ' creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('professions')->with('SecondarySaveProfession', 'Error!!, No es posible crear la profesión');
        }
            
    }
}
