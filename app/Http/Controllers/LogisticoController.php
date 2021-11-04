<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Student;

class LogisticoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
