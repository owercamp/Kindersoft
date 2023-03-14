<?php

namespace App\Http\Controllers;

use App\Models\DailyStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyStudentController extends Controller
{
  public function __construct()
  {
  }

  public function index()
  {
    return view('modules.schedules.dailyPublic');
  }

  public function indexServerSide(Request $request)
  {
    ini_set('max_execution_set', 0);
    ini_set('memory_limit', '-1');

    $columns = array(
      0 => 'date',
      1 => 'cont',
      2 => 'action'
    );

    /**
     * Consulta del alumno
     */
    $consulta = DB::table('daily_students')->join('students', 'students.id', 'daily_students.id_student')->join('info_dailies', 'info_dailies.id_id', 'daily_students.id_daily')->select('info_dailies.id_fulldate as date', 'info_dailies.id_cont as cont');

    /**
     * Totales Datatable
     */
    $totalData = $consulta->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $clausulas = $consulta->whereBetween('info_dailies.created_at',['','']);
      $posts = $clausulas->offset($start)->limit($limit)->orderBy($order, $dir)->get();
      $totalFiltered = $totalData;
    } else {
      $search = $request->input('search.value');
      $clausulas = $consulta->where("info_dailies.id_hi", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("info_dailies.id_cont", "like", "%{$search}%");
      $clausulas = $consulta->orWhere("info_dailies.note", "like", "%{$search}%");

      $totalFiltered = $clausulas->count();
      $posts = $clausulas->offset($start)->limit($limit)->orderBy($order, $dir)->get();
    }

    /**
     * Array de los Datos
     */
    $data = array();
    if ($posts) {
      foreach ($posts as $key => $register) {
        $nestedData['date'] = $register->date;
        $nestedData['cont'] = $register->cont;
        $nestedData['action'] = $register;
        $data[] = $nestedData;
      }
    }
    $json_data = array(
      "draw"            => intval($request->input('draw')),
      "recordsTotal"    => intval($totalData),
      "recordsFiltered" => intval($totalFiltered),
      "data"            => $data
    );
    return json_encode($json_data);
  }
}
