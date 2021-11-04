<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComercialController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function customerTo(){
    	return view('modules.customers');
    }

    public function enrollmentTo(){
    	return view('modules.enrollment');
    }

}
