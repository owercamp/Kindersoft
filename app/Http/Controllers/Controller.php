<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /* ===========================================================================================================
	        FUNCIONES PARA CONVERTIR CADENAS DE TEXTO (Mayusculas/Minusculas/Solo primera en Mayuscula)
	=========================================================================================================== */

	function upper($string){
	    return mb_strtoupper(trim($string),'UTF-8');
	}

	function lower($string){
	    return mb_strtolower(trim($string),'UTF-8');
	}

	function fu($string){
	    return ucfirst(mb_strtolower(trim($string),'UTF-8'));
	}
}
