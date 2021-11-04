<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Garden;
use App\Models\City;

use Hash;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$user = User::find(auth()->id());
    	$garden = Garden::select('garden.*','citys.name as nameCity','locations.name as nameLocation','districts.name as nameDistrict')
    					->join('citys','citys.id','garden.garCity_id')
    					->join('locations','locations.id','garden.garLocation_id')
    					->join('districts','districts.id','garden.garDistrict_id')
    					->first();
    	$citys = City::all();
    	return view('profile', compact('user','garden','citys'));
    }

    public function changePassword(Request $request){
		//dd($request->all());
		if($request->changePassword == 'NO'){
			$updateUser = User::where('id',$request->id)
								->where('id','!=',auth()->id())->first();
			if($updateUser == null){
				$user = User::find(auth()->id());
				$user->id = $request->id;
				$user->firstname = $request->firstname;
				$user->lastname = $request->lastname;
				$user->save();
				return redirect()->route('profile')->with('PrimaryUpdateUser', 'Datos de acceso actualizados correctamente');
			}else{
				return redirect()->route('profile')->with('SecondaryUpdateUser', 'No es posible actualizar los datos de acceso ahora, comuniquese con el administrador');
			}
		}else if($request->changePassword == 'SI'){
			if($request->newPassword == $request->confirmPassword){
				if(Hash::check($request->nowPassword, Auth::user()->password)){
					$user = User::find(auth()->id());
					$user->id = $request->id;
					$user->firstname = $request->firstname;
					$user->lastname = $request->lastname;
					$user->password = bcrypt(trim($request->newPassword));
					$user->save();
					return redirect()->route('profile')->with('PrimaryUpdateUser', 'Sus datos y contraseña estan actualizados correctamente');
				}else{
					return redirect()->route('profile')->with('SecondaryUpdateUser', 'Los datos no coinciden, Intentelo nuevamente');
				}
			}else{
				return redirect()->route('profile')->with('SecondaryUpdateUser', 'La nueva contraseña no coincide con la confirmación');
			}
		}		
	}
}
