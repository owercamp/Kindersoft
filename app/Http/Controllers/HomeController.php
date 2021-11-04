<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\User;


//Auth
use Illuminate\Support\Facades\Auth;

use Illuminate\Cache\CacheManager;

//use App\Models\User;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(cal_info());
        // $user = User::create([
        //     'id' => '108793',
        //     'firstname' => 'Carolina',
        //     'lastname' => 'Espitia',
        //     'password' =>  bcrypt('carol123')
        // ])->assignRole('ADMINISTRADOR SISTEMA');

        //$role = Role::findById(6);

        //$user = Auth::user();

        //cache('roll',$user->getRoleNames()[0],60);


         //$role = $user->getRoleNames()[0];
        //dd($user->getRoleNames()[0]);

        //$rol = $user->givePermissionTo('ADMINISTRATIVO');
        //$rol = $user->givePermissionTo('LOGISTICO');

        //$rol = $user->roles->implode('name',', ');
        
        //Asignar un rol al usuario
        //$rol = $user->assignRole('ADMIN-SYSTEM');
        //$rol = $user->getAllPermissions(); //Obtener todos los permisos del usuario
        //$rol = $user->getRoleNames(); //Obtiene los roles relacionados con el usuario
        //$rol = User::role('ADMIN-SYSTEM')->get(); //Obtiene los usuarios con role ADMIN-SYSTEM
        //$rol = User::permission('COMERCIAL')->get(); //Obtiene los usuarios con permisos COMERCIAL
        //$rol = $user->removeRole('ADMIN-LOG'); //Obtiene los usuarios con permisos COMERCIAL

        //dd($rol);


        return view('home');



        //SPATIE-PERMISSION

        //Ejemplo: $role = $user;

        //Asignar un rol al usuario
        //$user->assignRole('Administrator');

        //Crear un rol
        //$role = Role::create(['name' => 'Administrator']);

        //Crear un permiso
        //Permission::create(['name' => 'action']);
        
        // Dar permiso a un rol existente
        // $roles->givePermissionTo('action');

        //Validar un permiso para un rol
        //$role->hasPermissionTo('action');

        //Verificar si el rol del usuario autentificado contiene un permiso

        //EN KA VISTA CON LA DIRECTIVA @ can ... @ else ... @ endcan
        // DIr

    }


    function directionSee($direction = '/home'){
        switch ($direction) {
            case '/home': return "INICIO"; break;
            case '/home': return "INICIO"; break;
            default: return "ESCRITORIO"; break;
        }
    }
}
