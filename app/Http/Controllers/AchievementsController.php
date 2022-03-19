<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Achievement;
use App\Models\Intelligence;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AchievementsFromExcel;


class AchievementsController extends Controller
{
    function index(){
        $achievements = Achievement::all();
        $intelligences = Intelligence::all();
        return view('modules.achievements.index', compact('achievements', 'intelligences'));
    }

    function editAchievement($id){ 
        $achievement = Achievement::find($id);
        $intelligences = Intelligence::all();
        return view('modules.achievements.edit', compact('achievement', 'intelligences')); 
    }

    function updateAchievement(Request $request, $id){
        try{
            $achievement = Achievement::find($id);
            $achievement->name = mb_strtoupper($request->name);
            $achievement->description = mb_strtoupper(trim($request->description));
            $achievement->intelligence_id = trim($request->intelligence_id);
            $achievement->save();
            return redirect()->route('achievements')->with('PrimaryUpdateAchievement', 'Registro: ' . mb_strtoupper($request->name) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('achievements')->with('SecondaryUpdateAchievement', 'Error!!, No es posible actualizar el logro');
        } 
    }

    function deleteAchievement($id){
        try{
            $achievement = Achievement::find($id);
            $nameachievement = $achievement->name;
            $achievement->delete();
            return redirect()->route('achievements')->with('WarningDeleteAchievement', 'Registro: ' . $nameachievement . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('achievements')->with('SecondaryDeleteAchievement', 'No es posible eliminar el logro ahora, comuniquese con el administrador');
        }
    }

    function newAchievement(Request $request){
        try{
            $achievementSave = Achievement::where('name',mb_strtoupper($request->name))
                        ->where('description',mb_strtoupper($request->description))
                        ->first();
            //dd($achievementSave);
            if($achievementSave == null){
                Achievement::create([
                    'name' => mb_strtoupper($request->name),
                    'intelligence_id' => trim($request->intelligence_id),
                    'description' => mb_strtoupper(trim($request->description)),
                ]);
                return redirect()->route('achievements')->with('SuccessSaveAchievement', 'Registro: ' . mb_strtoupper($request->name) . ' creado correctamente');
            }else{
                 return redirect()->route('achievements')->with('SecondarySaveAchievement', 'Ya existe un registro con el mismo nombre y descripción');
            }
            /*Achievement::firstOrCreate([
                    'name' => strtoupper($request->name),
                    'intelligence_id' => $request->intelligence_id,
                    'description' => ucfirst(strtolower($request->description)),
                ],[
                    'name' => strtoupper($request->name),
                    'description' => ucfirst(strtolower($request->description)),
                    'intelligence_id' => $request->intelligence_id,
                ]
            );
            return redirect()->route('achievements')->with('SuccessSaveAchievement', 'Registro: ' . strtoupper($request->name) . ', creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('achievements')->with('SecondarySaveAchievement', 'No es posible crear el logro ahora, comuniquese con el administrador');
        } 
    }

    function importExcelAchievement(Request $request){
        $fileExcel = $request->file('excel');
        // dd($fileExcel);
        Excel::import(new AchievementsFromExcel, $fileExcel);
    }
}
