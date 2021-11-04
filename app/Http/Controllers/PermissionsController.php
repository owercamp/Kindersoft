<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    function index(){
        $permissions = Permission::orderBy('id', 'DESC')->paginate();
        return view('modules.permissions.index', compact('permissions'));
    }

    function editPermission($id){ 
        $permission = Permission::find($id);
        return view('modules.permissions.edit', compact('permission')); 
    }

    function updatePermission(Request $request, $id){
        $permission = Permission::find($id);
        $permission->name = strtoupper($request->name);
        $permission->save();
        return redirect()->route('permissions');
    }

    function deletePermission($id){
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions');
    }

    function newPermission(Request $request){
        // Permission::create(['name' => $request->name]);
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions');
    }
}
