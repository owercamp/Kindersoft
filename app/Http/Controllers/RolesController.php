<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    function index(){
        $rolesPermission = Role::withCount(['permissions'])->get();
        return view('modules.permissions-roles.index', compact('rolesPermission'));
    }

    function editRole($id){
    	//Encontrar rol
        $role = Role::find($id);
        //Consultar permisos asociados al rol

        return view('modules.permissions-roles.edit', compact('role')); 
    }

    function updateRole(Request $request, $id){
        $role = Role::find($id);
        $role->name = strtoupper($request->name);
        $role->save();
        return redirect()->route('roles');
    }

    function deleteRole($id){
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles');
    }

    function newRole(Request $request){
        // role::create(['name' => $request->name]);
        Role::create(['name' => $request->name]);
        return redirect()->route('roles');
    }
}
