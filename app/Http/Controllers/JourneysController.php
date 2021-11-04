<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Journey;

class JourneysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $journeys = Journey::all();
        return view('modules.journeys.index', compact('journeys'));
    }

    function editJourney($id){ 
        $journey = Journey::find($id);
        return view('modules.journeys.edit', compact('journey')); 
    }

    function updateJourney(Request $request, $id){
        try{
            $journeyUpdate = Journey::where('jouJourney', trim(strtoupper($request->jouJourney)))
                                ->where('jouDays', trim(strtoupper($request->fullDays)))
                                ->where('jouHourEntry', trim($request->jouHourEntry))
                                ->where('jouHourExit', trim($request->jouHourExit))
                                ->where('jouValue', trim($request->jouValue))
                                ->first();
            if($journeyUpdate == null){
                $journey = Journey::find($id);
                $journey->jouJourney = trim(ucfirst(strtolower($request->jouJourney)));
                $journey->jouDays = trim($request->fullDays);
                $journey->jouHourEntry = trim($request->jouHourEntry);
                $journey->jouHourExit = trim($request->jouHourExit);
                $journey->jouValue = trim($request->jouValue);
                $journey->save();
                return redirect()->route('journeys')->with('PrimaryUpdateJourney', 'Registro: ' . ucfirst(strtolower($request->jouJourney)) . ', actualizado correctamente');
            }else{
                return redirect()->route('journeys')->with('SecondaryUpdateJourney', 'Registro: ' . ucfirst(strtolower($request->jouJourney)) . ', NO ACTUALIZADO, Ya existe un registro con el concepto de jornada modificado');
            }
        }catch(Exception $ex){
            return redirect()->route('journeys')->with('SecondaryUpdateJourney', 'Error!!, No es posible actualizar la jornada');
        }
    }

    function deleteJourney($id){
        try{
            $journey = Journey::find($id);
            $namejourney = $journey->jouJourney;
            $journey->delete();
            return redirect()->route('journeys')->with('WarningDeleteJourney', 'Registro: ' . $namejourney . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('journeys')->with('SecondaryDeleteJourney', 'Error!!, No es posible eliminar la jornada');
        }
    }

    function newJourney(Request $request){
        return view('modules.journeys.new');
    }

    function saveJourney(Request $request){
        try{
        	$journeySave = Journey::where('jouJourney', trim(strtoupper($request->jouJourney)))
                                ->where('jouDays', trim(strtoupper($request->fullDays)))
                                ->first();
            if($journeySave == null){
                Journey::create([
                    'jouJourney' => trim(ucfirst(strtolower($request->jouJourney))),
                    'jouDays' => trim(strtoupper($request->fullDays)),
                    'jouHourEntry' => trim($request->jouHourEntry),
                    'jouHourExit' => trim($request->jouHourExit),
                    'jouValue' => trim($request->jouValue),
                ]);
                return redirect()->route('journeys')->with('SuccessSaveJourney', 'Registro: ' . ucfirst(strtolower($request->jouJourney)). ', creado correctamente');
            }else{
                 return redirect()->route('journeys')->with('SecondarySaveJourney', 'Ya existe un registro ' . strtoupper($request->jouJourney) . ' con los dias asignados');
            }
            /*Journey::firstOrCreate([
                    'jouJourney' => ucfirst(strtolower($request->jouJourney)),
                    'jouDays' => $request->fullDays,
                ],[
                    'jouJourney' => ucfirst(strtolower($request->jouJourney)),
                    'jouDays' => $request->fullDays,
                    'jouHourEntry' => $request->jouHourEntry,
                    'jouHourExit' => $request->jouHourExit,
                    'jouValue' => $request->jouValue,
                ]
            );
            return redirect()->route('journeys')->with('SuccessSaveJourney', 'Registro: ' . ucfirst(strtolower($request->jouJourney)) . ', creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('journeys')->with('SecondarySaveJourney', 'Error!!, No es posible crear la jornada');
        }
    }
}
