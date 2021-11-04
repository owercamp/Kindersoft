<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Observation;
use App\Models\Intelligence;

class ObservationsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    function observationsTo(){
        $observations = Observation::select('observations.*','intelligences.type')->join('intelligences','intelligences.id','observations.obsIntelligence_id')->get();
        $intelligences = Intelligence::all();
        return view('modules.evaluations.observations', compact('observations','intelligences'));
    }

    function newObservations(Request $request){
    	//dd($request->all());
    	try{
            $observationValidate = Observation::where('obsNumber',trim($request->obsNumber))->first();
            if($observationValidate == null){
                Observation::create([
                    'obsNumber' => trim($request->obsNumber),
                    'obsDescription' => trim(ucfirst(mb_strtolower($request->obsDescription,'UTF-8'))),
                    'obsIntelligence_id' => trim($request->obsIntelligence_id)
                ]);
                return redirect()->route('observations')->with('SuccessSaveObservations', 'Observación con número ' . trim($request->obsNumber) . ', creada correctamente');
            }else{
                return redirect()->route('observations')->with('SecondarySaveObservations', 'Ya existe una observación con número ' . trim($request->obsNumber));
            }
        }catch(Exception $ex){
            return redirect()->route('observations')->with('SecondarySaveObservations', 'No es posible crear la observación, Comuníquese con el administrador');
        }
    }

    function updateObservations(Request $request){
    	//dd($request->all());
    	try{
            $observationNumberValidate = Observation::where('obsId','!=',trim($request->obsIdEdit))
                                                    ->Where('obsNumber',trim($request->obsNumberEdit))
                                                    ->Where('obsDescription',trim(ucfirst(mb_strtolower($request->obsDescriptionEdit,'UTF-8'))))
                                                    ->Where('obsIntelligence_id',trim($request->obsIntelligence_idEdit))
                                                    ->first();
            if($observationNumberValidate == null){
                $observationToUpdate = Observation::find(trim($request->obsIdEdit));
                $observationToUpdate->obsNumber = trim($request->obsNumberEdit);
                $observationToUpdate->obsDescription = trim(ucfirst(mb_strtolower($request->obsDescriptionEdit,'UTF-8')));
                $observationToUpdate->obsIntelligence_id = trim($request->obsIntelligence_idEdit);
                $observationToUpdate->save();
                return redirect()->route('observations')->with('PrimaryUpdateObservations', 'Observación con número ' . trim($request->obsNumberEdit) . ', modificada correctamente');
            }else{
                return redirect()->route('observations')->with('SecondaryUpdateObservations', 'Ya existe una observación con el numero, descripción e inteligencia');
            }
        }catch(Exception $ex){
            return redirect()->route('observations')->with('SecondaryUpdateObservations', 'No es posible actualizar la observación, Comuníquese con el administrador');
        }
    }

    function deleteObservations(Request $request){
    	//dd($request->all());
    	try{
            $observationToDelete = Observation::find(trim($request->obsIdDelete));
            $numberObservation = $observationToDelete->obsNumber;
            $observationToDelete->delete();
            return redirect()->route('observations')->with('WarningDeleteObservations', 'Observación con numero ' . $numberObservation . ', Eliminada');
        }catch(Exception $ex){
            return redirect()->route('observations')->with('SecondaryDeleteObservations', 'No es posible eliminar la observación, Comuníquese con el administrador');
        }
    }

}
