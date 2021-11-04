<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewUserRequest;
use App\Models\User;
use App\Models\Collaborator;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(){
        $users = User::all()
        ->where('id','!=', auth()->id())
        ->where('id','!=', '1024537577');
        return view('modules.users.index', compact('users'));
    }

    function editUser($id){ 
        $user = User::find($id);
        $roles = Role::where('name','!=','ADMINISTRADOR SISTEMA')->get();
        $collaborator = Collaborator::find($user->collaborator_id);
        return view('modules.users.edit', compact('user','roles','collaborator')); 
    }

    function updateUser(Request $request, $id){
        try{
            $userUpdate = User::where('id',$request->id_new)->where('id','!=',$request->id_old)->first();
            if($userUpdate == null){
                $user = User::find($id);
                $user->id = $request->id_new;
                $user->firstname = strtoupper($request->firstname);
                $user->lastname = strtoupper($request->lastname);
                $user->collaborator_id = trim($request->collaborator);
                $rolnow = '';
                if($request->role != 'Indefinido'){
                    if(isset($user->getRoleNames()[0]) && $user->getRoleNames()[0] !== ''){
                        $user->removeRole($user->getRoleNames()[0]);
                        $user->assignRole($request->role);
                    }else{
                        $user->assignRole($request->role);
                    }
                }else if($request->role == 'Indefinido'){
                    if(isset($user->getRoleNames()[0]) && $user->getRoleNames()[0] != ''){
                        $rolnowuser = $user->getRoleNames()[0];
                        $user->removeRole($rolnowuser);
                    }
                }
                $user->save();
                return redirect()->route('users')->with('PrimaryUpdateUser', 'Usuario con ID: ' . $request->id_new . ', actualizado correctamente');
            }else{
                return redirect()->route('users')->with('SecondaryUpdateUser', 'Usuario ' . $request->id_old . ' NO ACTUALIZADO, Ya existe un usuario con el ID ' . $request->id_new);
            }
        }catch(Exception $ex){
            return redirect()->route('users')->with('SecondaryUpdateUser', 'Error!!, No fue posible eliminar el usuario');
        }
    }

    function deleteUser($id){
        try{
            $user = User::find($id);
            $nameuser = $user->firstname . ' ' . $user->lastname;
            $user->delete();
            return redirect()->route('users')->with('WarningDeleteUser', 'Registro ' . $nameuser . ', eliminado correctamente');
        }catch(Exception $ex){
            return redirect()->route('users')->with('SecondaryDeleteUser', 'Error!!, No fue posible eliminar el usuario');
        }
    }

    function newUser(){
        $roles = Role::where('name','!=','ADMINISTRADOR SISTEMA')->get();
        $collaborators = Collaborator::all();
        return view('modules.users.new', compact('roles','collaborators')); 
    }

    function newsaveUser(Request $request){
        try{
            $userSave = User::where('id',$request->id)->first();
            if($userSave == null){
                User::create([
                    'id' => trim($request->id),
                    'firstname' => mb_strtoupper($request->firstname),
                    'lastname' => mb_strtoupper($request->lastname),
                    'password' => bcrypt('kindersoft2019'),
                    'collaborator_id' => trim($request->collaborator),
                ]);
                if($request->role !== 'Indefinido'){
                    User::find($request->id)->assignRole($request->role);
                }
                return redirect()->route('user.new')->with('SuccessSaveUser', 'Registro con ID: ' . $request->id . ', creado correctamente');
            }else{
                 return redirect()->route('user.new')->with('SecondarySaveUser', 'Ya existe un usuario con el ID: ' . $request->id);
            }
            /* User::firstOrCreate([
                'id' => $request->id,
                'password' => bcrypt('kindersoft2019'),
            ],[
                'id' => $request->id,
                'firstname' => strtoupper($request->firstname),
                'lastname' => strtoupper($request->lastname),
                'password' => bcrypt('kindersoft2019'),
            ]);
            if($request->role !== 'Indefinido'){
                User::find($request->id)->assignRole($request->role);
            }
            return redirect()->route('user.new')->with('SuccessSaveUser', 'Registro con ID: ' . $request->id . ', creado correctamente'); */
        }catch(Exception $ex){
            return redirect()->route('user.new')->with('SecondarySaveUser', 'Error!! No es posible crear el usuario');
        }
            
    }
}
