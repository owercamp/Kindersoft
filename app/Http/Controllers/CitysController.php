<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Location;
use App\Models\District;

class CitysController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $citys = City::all();
        return view('modules.citys.index', compact('citys'));
    }

    function editCity($id){ 
        $city = City::find($id);
        return view('modules.citys.edit', compact('city')); 
    }

    function updateCity(Request $request, $id){
        try{
            $city = City::find($id);
            $city->name = strtoupper($request->name);
            $city->save();
            return redirect()->route('citys')->with('PrimaryUpdateCity', 'Registro: ' . strtoupper($request->name) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('citys')->with('SecondaryUpdateCity', 'Error!!, No es posible actualizar la ciudad');
        }
    }

    function deleteCity($id){
        try{
            //Eliminaciòn en cascada de las ciudades y las localidades y barrios relacionados

            // 1.) Buscar la ciudad con su ID;
            $city = City::find($id);
            // 2.) Guardar nombre para mensaje final
            $namecity = $city->name;
            // 3.) Buscar las localidades relacionadas con la ciudad
            $locations = Location::where('city_id', $city->id)->get();
            // 4.) Eliminar los barrios relacionados con las localidades y luego borrar la localidad
            foreach ($locations as $location) {
                District::where('location_id',$location->id)->delete();
                Location::where('id',$location->id)->delete();
            }
            // 5.) Eliminar las ciudades
            $city->delete();
            return redirect()->route('citys')->with('WarningDeleteCity', 'Registro: ' . $namecity . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('citys')->with('SecondaryDeleteCity', 'Error!!, No es posible eliminar la ciudad');
        }
    }

    function newCity(Request $request){
        try{
            $citySave = City::where('name',strtoupper($request->name))->first();
            if($citySave == null){
                City::create([
                    'name' => strtoupper($request->name),
                ]);
                return redirect()->route('citys')->with('SuccessSaveCity', 'Registro: ' . strtoupper($request->name) . ' creado correctamente');
            }else{
                 return redirect()->route('citys')->with('SecondarySaveCity', 'Ya existe un registro ' . strtoupper($request->name));
            }
        }catch(Exception $ex){
            return redirect()->route('citys')->with('SecondarySaveCity', 'Error!!, No es posible crear la ciudad');
        }
    }
}
