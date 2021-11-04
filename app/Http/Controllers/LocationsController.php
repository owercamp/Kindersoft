<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Location;
use App\Models\District;

/*
        try{

        }catch(Exception $ex){

        }
*/

class LocationsController extends Controller
{
    function index(){
        $locations = Location::all();
        $citys = City::all();
        return view('modules.locations.index', compact('locations', 'citys'));
    }

    function editLocation($id){ 
        $location = Location::find($id);
        $citys = City::all();
        return view('modules.locations.edit', compact('location', 'citys')); 
    }

    function updateLocation(Request $request, $id){
        try{
            $validateLocation = Location::where('name',trim(strtoupper($request->name)))
                                    ->where('city_id',trim($request->city_id))
                                    ->where('id','!=',$id)->first();
            if($validateLocation == null){
                $location = Location::find($id);
                $location->name = trim(strtoupper($request->name));
                $location->city_id = trim($request->city_id);
                $location->save();
                return redirect()->route('locations')->with('PrimaryUpdateLocation', 'Registro: ' . strtoupper($request->name) . ', actualizado correctamente');
            }else{
                $city = City::find(trim($request->city_id));
                return redirect()->route('locations')->with('SecondaryUpdateLocation', 'Ya existe el registro: ' . strtoupper($request->name) . ' para la ciudad ' . $city->name);
            }
        }catch(Exception $ex){
            return redirect()->route('locations')->with('SecondaryUpdateLocation', 'Error!!, No es posible actualizar la localidad');
        }
    }

    function deleteLocation($id){
        try{
            //Eliminación en cascada de la localidad y barrios relacionados
            // 1.) Buscar la localidad con su ID;
            $location = Location::find($id);
            // 2.) Guardar nombre para mensaje final
            $namelocation = $location->name;
            // 3.) Buscar los barrios relacionados con la localidad
            $districts = District::where('location_id', $location->id)->get();
            // 4.) Eliminar los barrios relacionados con la localidade
            foreach ($districts as $district) {
                District::where('id',$district->id)->delete();
            }
            // 5.) Eliminar la localidad
            $location->delete();
            return redirect()->route('locations')->with('WarningDeleteLocation', 'Registro: ' . $namelocation . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('locations')->with('SecondaryDeleteLocation', 'Error!!, No es posible eliminar la localidad');
        }
    }

    function newLocation(Request $request){
        try{
            $locationSave = Location::where('name',strtoupper($request->name))
                            ->where('city_id',$request->city_id)
                            ->first();
            if($locationSave == null){
                Location::create([
                    'name' => strtoupper($request->name),
                    'city_id' => $request->city_id,
                ]);
                return redirect()->route('locations')->with('SuccessSaveLocation', 'Registro: ' . strtoupper($request->name) . ' creado correctamente');
            }else{
                 return redirect()->route('locations')->with('SecondarySaveLocation', 'Ya existe un registro ' . strtoupper($request->name) . ' para la ciudad seleccionada');
            }
            /*Location::firstOrCreate([
                    'name' => strtoupper($request->name),
                    'city_id' => $request->city_id,
                ],[
                    'name' => strtoupper($request->name),
                    'city_id' => $request->city_id,
                ]
            );
            return redirect()->route('locations')->with('SuccessSaveLocation', 'Registro: ' . strtoupper($request->name) . ' creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('locations')->with('SecondarySaveLocation', 'Error!!, No es posible crear la localidad');
        }    
    }
}
