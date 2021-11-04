<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\District;
use App\Models\Location;
use App\Models\City;

class DistrictsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $districts = District::all();
        $citys = City::all();
        return view('modules.districts.index', compact('districts', 'citys'));
    }

    function editDistrict($id){
        try{
            $district = District::find($id);//Selecciona el barrios
            $location = Location::where('id','=',$district->location_id)->first();//Localidad del barrio
            $city_from_district = City::where('id','=',$location->city_id)->get();
            $citys = City::all();
            return view('modules.districts.edit', compact('district','citys','location','city_from_district'));
        }catch(Exception $ex){
            return redirect()->route('districts')->with('SecondaryUpdateDistrict', 'Error!!, No es posible actualizar el barrio');
        }
    }

    function updateDistrict(Request $request, $id){
        try{
            $district = District::find($id);
            $district->name = strtoupper($request->name);
            $district->location_id = $request->location_id;
            $district->save();
            return redirect()->route('districts')->with('PrimaryUpdateDistrict', 'Registro: ' . strtoupper($request->name) . ', actualizado correctamente');
        }catch(Exception $ex){
            return redirect()->route('districts')->with('SecondaryUpdateDistrict', 'Error!!, No es posible actualizar el barrio');
        }
    }

    function deleteDistrict($id){
        try{
            $district = District::find($id);
            $namedistrict = $district->name;
            $district->delete();
            return redirect()->route('districts')->with('WarningDeleteDistrict', 'Registro: ' . $namedistrict . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('districts')->with('SecondaryDeleteDistrict', 'Error!!, No es posible eliminar el barrio');
        }   
    }

    function newDistrict(Request $request){
        try{
            $districtSave = District::where('name',strtoupper($request->name))
                            ->where('location_id',$request->location_id)
                            ->first();
            if($districtSave == null){
                District::create([
                    'name' => strtoupper($request->name),
                    'location_id' => $request->location_id,
                ]);
                return redirect()->route('districts')->with('SuccessSaveDistrict', 'Registro: ' . strtoupper($request->name) . ' creado correctamente');
            }else{
                 return redirect()->route('districts')->with('SecondarySaveDistrict', 'Ya existe un registro ' . strtoupper($request->name) . ' para la localidad seleccionada');
            }
            /*District::firstOrCreate([
                    'name' => strtoupper($request->name),
                    'location_id' => $request->location_id,
                ],[
                    'name' => strtoupper($request->name),
                    'location_id' => $request->location_id,
                ]
            );
            return redirect()->route('districts')->with('SuccessSaveDistrict', 'Registro: ' . strtoupper($request->name) . ' creado correctamente');*/
        }catch(Exception $ex){
            return redirect()->route('districts')->with('SecondarySaveDistrict', 'Error!!, No es posible crear el barrio');
        } 
    }
}
