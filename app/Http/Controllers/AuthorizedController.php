<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Document;

use App\Models\Authorized;
use App\Models\Legalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorizedController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    $authorizeds = Authorized::select('authorized.*', 'documents.type')
      ->join('documents', 'documents.id', 'autDocument_id')->get();
    return view('modules.authorized.index', compact('authorizeds'));
  }

  function newAuthorized()
  {
    $documents = Document::all();
    return view('modules.authorized.new', compact('documents'));
  }

  function saveAuthorized(Request $request)
  {
    try {
      //dd($request->all());
      $authorizedSave = Authorized::where('autDocument_id', trim($request->typedocument_id))
        ->where('autNumberdocument', trim($request->numberdocument))
        ->first();
      if ($authorizedSave == null) {
        if ($request->hasFile('autPhoto')) {
          $photo = $request->file('autPhoto');
          $namephoto = $photo->getClientOriginalName();
          Storage::disk('kindersoft')->putFileAs('authorized', $photo, $namephoto);
          Authorized::create([
            'autDocument_id' => $request->autDocument_id,
            'autNumberdocument' => $request->autNumberdocument,
            'autFirstname' => mb_strtoupper(trim($request->autFirstname)),
            'autLastname' => mb_strtoupper(trim($request->autLastname)),
            'autRelationship' => mb_strtoupper(trim($request->autRelationship)),
            'autPhoneone' => $request->autPhoneone,
            'autPhonetwo' => $request->autPhonetwo,
            'autObservations' => mb_strtoupper(trim($request->autObservations)),
            'autPhoto' => $namephoto
          ]);
          return redirect()->route('authorized')->with('SuccessSaveAuthorized', 'Autorizado con ID: ' . $request->autNumberdocument . ' guardado correctamente');
        } else {
          Authorized::create([
            'autDocument_id' => $request->autDocument_id,
            'autNumberdocument' => $request->autNumberdocument,
            'autFirstname' => mb_strtoupper(trim($request->autFirstname)),
            'autLastname' => mb_strtoupper(trim($request->autLastname)),
            'autRelationship' => mb_strtoupper(trim($request->autRelationship)),
            'autPhoneone' => $request->autPhoneone,
            'autPhonetwo' => $request->autPhonetwo,
            'autObservations' => mb_strtoupper(trim($request->autObservations))
          ]);
          return redirect()->route('authorized')->with('SuccessSaveAuthorized', 'Autorizado con ID: ' . $request->autNumberdocument . ' guardado correctamente');
        }
      } else {
        return redirect()->route('authorized')->with('SecondarySaveAuthorized', 'Ya existe un autorizado con el número de identificación ingresado');
      }
    } catch (Exception $ex) {
      return redirect()->route('authorized')->with('SecondarySaveAuthorized', 'No es posible crear el registro ahora, comuniquese con el administrador');
    }
  }

  function editAuthorized($id)
  {
    $authorized = Authorized::find($id);
    $documents = Document::all();
    return view('modules.authorized.edit', compact('authorized', 'documents'));
  }

  function updateAuthorized(Request $request, $id)
  {
    try {
      $authorizedUpdate = Authorized::where('autDocument_id', trim($request->autDocument_id))
        ->where('autNumberdocument', trim($request->autNumberdocument))
        ->where('autId', '!=', $id)
        ->first();
      if ($authorizedUpdate == null) {
        if ($request->hasFile('autPhoto')) {
          $photo = $request->file('autPhoto');
          $namephoto = $photo->getClientOriginalName();
          Storage::disk('kindersoft')->putFileAs('authorized', $photo, $namephoto);
          $authorized = Authorized::find($id);
          $authorized->autDocument_id = $request->autDocument_id;
          $authorized->autNumberdocument = $request->autNumberdocument;
          $authorized->autFirstname = mb_strtoupper(trim($request->autFirstname));
          $authorized->autLastname = mb_strtoupper(trim($request->autLastname));
          $authorized->autPhoto = $namephoto;
          $authorized->autPhoneone = $request->autPhoneone;
          $authorized->autPhonetwo = $request->autPhonetwo;
          $authorized->autRelationship = mb_strtoupper($request->autRelationship);
          $authorized->autObservations = mb_strtoupper($request->autObservations);
          $authorized->save();
          return redirect()->route('authorized')->with('PrimaryUpdateAuthorized', 'Autorizado con ID: ' . $request->autNumberdocument . ' actualizado correctamente');
        } else {
          $authorized = Authorized::find($id);
          $authorized->autDocument_id = $request->autDocument_id;
          $authorized->autNumberdocument = $request->autNumberdocument;
          $authorized->autFirstname = mb_strtoupper(trim($request->autFirstname));
          $authorized->autLastname = mb_strtoupper(trim($request->autLastname));
          $authorized->autPhoneone = $request->autPhoneone;
          $authorized->autPhonetwo = $request->autPhonetwo;
          $authorized->autRelationship = mb_strtoupper($request->autRelationship);
          $authorized->autObservations = mb_strtoupper($request->autObservations);
          $authorized->save();
          return redirect()->route('authorized')->with('PrimaryUpdateAuthorized', 'Autorizado con ID: ' . $request->autNumberdocument . ' actualizado correctamente');
        }
      } else {
        return redirect()->route('students')->with('SecondaryUpdateAuthorized', 'Autorizado@ con ID: ' . $request->autNumberdocument . ' NO ACTUALIZADO, Ya existe un registro con el número de identificación ingresado');
      }
    } catch (Exception $ex) {
      return redirect()->route('authorized')->with('SecondaryUpdateAuthorized', 'No fue posible actualizar ahora, comuniquese con el administrador');
    }
  }

  function deleteAuthorized($id)
  {
    try {
      $authorized = Authorized::find($id);
      $names = $authorized->autFirstname . " con ID: " . $authorized->autNumberdocument;
      $authorized->delete();
      return redirect()->route('attendants')->with('WarningDeleteAuthorized', 'Registro de ' . $names . ', eliminado correctamente');
    } catch (Exception $ex) {
      return redirect()->route('attendants')->with('SecondaryDeleteAuthorized', 'No fue posible eliminar ahora, comuniquese con el administrador');
    }
  }

  function activeAuthorized($id)
  {
    $approved = Authorized::find($id);
    // return $approved;
    $validate = Legalization::where('legAttendantmother_id', trim($approved->autDocument_id))
      ->orWhere('legAttendantfather_id', trim($approved->autDocument_id))
      ->first();
    if ($validate == null) {
      $approved = Authorized::find($id);
      if ($approved != null) {
        $approved->status = "INACTIVO";
        $approved->save();
        return redirect()->route('authorized')->with('PrimaryUpdateAuthorized', 'El registro de autorización del ' . $this->upper($approved->autRelationship) . ' ' . $this->upper($approved->autFirstname) . ' a cambiado al estado de INACTIVO');
      }
      return redirect()->route('authorized')->with('SecondaryDeleteAuthorized', 'Error al actualizar el estado del autorizado');
    } else {
      return redirect()->route('authorized')->with('SecondaryDeleteAuthorized', 'El ' . $this->upper($approved->autRelationship) . ' ' . $this->upper($approved->autFirstname) . ' del registro que intenta inhabilitar se encuentra con contratos relacionados');
    }
  }
  function inactiveAuthorized($id)
  {
    $approved = Authorized::find($id);
    // return $approved;
    $validate = Legalization::where('legAttendantmother_id', trim($approved->autDocument_id))
      ->orWhere('legAttendantfather_id', trim($approved->autDocument_id))
      ->first();
    if ($approved != null) {
      $approved->status = "ACTIVO";
      $approved->save();
      return redirect()->route('authorized')->with('PrimaryUpdateAuthorized', 'El registro de autorización del ' . $this->upper($approved->autRelationship) . ' ' . $this->upper($approved->autFirstname) . ' a cambiado al estado de ACTIVO');
    }
    return redirect()->route('authorized')->with('SecondaryDeleteAuthorized', 'Error al actualizar el estado de autorizado');
  }

  function detailsAuthorized($id)
  {
    $authorized = Authorized::select('authorized.*', 'documents.type')
      ->join('documents', 'documents.id', 'autDocument_id')
      ->where('autId', $id)->first();
    return view('modules.authorized.details', compact('authorized'));
  }
}
