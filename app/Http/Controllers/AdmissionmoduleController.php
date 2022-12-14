<?php

namespace App\Http\Controllers;

use Exception;

use Carbon\Carbon;

use App\Models\City;

use App\Models\Garden;
use App\Models\Health;
use App\Models\Student;
use App\Models\District;
use App\Models\Document;
use App\Models\Location;
use App\Models\Attendant;
use App\Models\Bloodtype;
use App\Models\Authorized;
use App\Models\Profession;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Formadmission;
use App\Models\RecordArchive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdmissionmoduleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  /*====================================================================
        NUEVAS FUNCIONES DE ACTUALIZACION - MANTENIMIENTO #7
    ====================================================================*/

  function registerTo()
  {
    $citys = City::all();
    $healths = Health::all();
    $locations = Location::all();
    $bloodtypes = Bloodtype::all();
    $typeDocuments = Document::all();
    return view('modules.admissionModule.form', compact('healths', 'citys', 'locations', 'bloodtypes', 'typeDocuments'));
  }

  function registerAdmission(Request $request)
  {
    /******
     * 
     * TRATAMIENTO DE INFORMACION INGRESA EN EL FORMULARIO, REEMPLAZANDO COMAS Y PUNTOS POR NADA
     * 
     */
    $myExpresions = array(",", ".");

    $direccionAcudiente1 = str_replace($myExpresions, "", $request->addressattendant1);
    $direccionAcudiente2 = str_replace($myExpresions, "", $request->addressattendant2);
    $formacionAcudiente1 = str_replace($myExpresions, "", $request->typeprofessionattendant1);
    $formacionAcudiente2 = str_replace($myExpresions, "", $request->typeprofessionattendant2);
    $nombreEmpresaAcudiente1 = str_replace($myExpresions, "", $request->bussinessattendant1);
    $nombreEmpresaAcudiente2 = str_replace($myExpresions, "", $request->bussinessattendant2);
    $direccionEmpresaAcudiente1 = str_replace($myExpresions, "", $request->addressbussinessattendant1);
    $direccionEmpresaAcudiente2 = str_replace($myExpresions, "", $request->addressbussinessattendant2);
    $nombreAlumno = str_replace($myExpresions, "", $request->firstname);
    $apellidoAlumno = str_replace($myExpresions, "", $request->lastname);
    $nacionalidad = str_replace($myExpresions, "", $request->nationality);
    $tituloAcudiente1 = str_replace($myExpresions, "", $request->tituloattendant1);
    $tituloAcudiente2 = str_replace($myExpresions, "", $request->tituloattendant2);
    $cargoAcudiente1 = str_replace($myExpresions, "", $request->positionattendant1);
    $cargoAcudiente2 = str_replace($myExpresions, "", $request->positionattendant2);

    /******
     * 
     * VALIDACION REGISTRO EXISTENTE PARA ACTUALIZAR O CREAR UNO NUEVO
     * 
     */

    $validateform = Formadmission::where('numerodocumento', trim($request->numberdocument))->first();
    if ($validateform == null) {
      $namephoto = "photodefault.png";
      if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        // $name = $rut->getClientOriginalName();
        $extension = $photo->extension();
        Storage::disk('kindersoft')->putFileAs('admisiones/fotosaspirantes/', $photo, trim($request->numberdocument) . '_photo.' . $extension);
        $namephoto = trim($request->numberdocument) . '_photo.' . $extension;
      }
      $datefechanacimiento = Date('Y-m-d', strtotime(
        trim($request->year) . '-' . trim($request->month) . '-' . trim($request->day)
      ));
      $datefechaingreso = Date('Y-m-d', strtotime(
        trim($request->yearentry) . '-' . trim($request->monthentry) . '-' . trim($request->dayentry)
      ));
      $datefechaingresoaudiente1 = Date('Y-m-d', strtotime(trim($request->dateentryattendant1)));
      $datefechaingresoaudiente2 = Date('Y-m-d', strtotime(trim($request->dateentryattendant2)));

      $formAdmission = new Formadmission;
      $formAdmission->foto = $namephoto;
      $formAdmission->nombres = $this->upper($nombreAlumno);
      $formAdmission->apellidos = $this->upper($apellidoAlumno);
      $formAdmission->genero = $this->upper($request->gender);
      $formAdmission->fechanacimiento = $datefechanacimiento;
      $formAdmission->tipodocumento = trim($request->typedocument);
      $formAdmission->numerodocumento = trim($request->numberdocument);
      $formAdmission->nacionalidad = $this->upper($nacionalidad);
      $formAdmission->mesesgestacion = trim($request->monthbord);
      $formAdmission->tiposangre = trim($request->bloodtype);
      $formAdmission->tipoparto = trim($request->typebord);
      $formAdmission->enfermedades = $this->fu($request->healthbad);
      $formAdmission->tratamientos = $this->fu($request->medical);
      $formAdmission->alergias = $this->fu($request->descripcionalergias);
      $formAdmission->asistenciaterapias = trim($request->terapia);
      $formAdmission->cual = $this->fu($request->whatterapia);
      $formAdmission->health = trim($request->health);
      $formAdmission->programa = trim($request->typeprogram);
      $formAdmission->numerohermanos = trim($request->brothers);
      $formAdmission->lugarqueocupa = trim($request->placebrother);
      $formAdmission->lugarqueocupa = trim($request->placebrother);
      $formAdmission->conquienvive = $this->upper($request->withlive);
      $formAdmission->otroscuidados = $this->fu($request->other);
      $formAdmission->nombreacudiente1 = $this->ucwords($request->nameattendant1);
      $formAdmission->documentoacudiente1 = trim($request->documentattendant1);
      $formAdmission->docacu1 = trim($request->typedocumentattendant1);
      $formAdmission->direccionacudiente1 = trim($direccionAcudiente1);
      $formAdmission->barrioacudiente1 = trim($request->barrioattendant1);
      $formAdmission->localidadacudiente1 = trim($request->localidadattendant1);
      $formAdmission->celularacudiente1 = trim($request->celularattendant1);
      $formAdmission->celularacudiente1 = trim($request->celularattendant1);
      $formAdmission->whatsappacudiente1 = trim($request->whatsappattendant1);
      $formAdmission->correoacudiente1 = $this->lower($request->emailattendant1);
      $formAdmission->formacionacudiente1 = trim($formacionAcudiente1);
      $formAdmission->tituloacudiente1 = $this->upper($tituloAcudiente1);
      $formAdmission->tipoocupacionacudiente1 = trim($request->typeworkattendant1);
      $formAdmission->empresaacudiente1 = $this->upper($nombreEmpresaAcudiente1);
      $formAdmission->direccionempresaacudiente1 = $this->upper($direccionEmpresaAcudiente1);
      $formAdmission->ciudadempresaacudiente1 = trim($request->citybussinessattendant1);
      $formAdmission->barrioempresaacudiente1 = trim($request->barrioempresaattendant1);
      $formAdmission->localidadempresaacudiente1 = trim($request->localidadempresaattendant1);
      $formAdmission->cargoempresaacudiente1 = $this->upper($cargoAcudiente1);
      $formAdmission->fechaingresoempresaacudiente1 = $datefechaingresoaudiente1;
      $formAdmission->rhacu1 = trim($request->bloodtypeattendant1);
      $formAdmission->sexoacudiente1 = trim($request->sexattendant1);
      $formAdmission->nombreacudiente2 = $this->ucwords($request->nameattendant2);
      $formAdmission->documentoacudiente2 = trim($request->documentattendant2);
      $formAdmission->docacu2 = trim($request->typedocumentattendant2);
      $formAdmission->direccionacudiente2 = trim($direccionAcudiente2);
      $formAdmission->barrioacudiente2 = trim($request->barrioattendant2);
      $formAdmission->localidadacudiente2 = trim($request->localidadattendant2);
      $formAdmission->celularacudiente2 = trim($request->celularattendant2);
      $formAdmission->whatsappacudiente2 = trim($request->whatsappattendant2);
      $formAdmission->correoacudiente2 = $this->lower($request->emailattendant2);
      $formAdmission->formacionacudiente2 = trim($formacionAcudiente2);
      $formAdmission->tituloacudiente2 = $this->upper($tituloAcudiente2);
      $formAdmission->tipoocupacionacudiente2 = trim($request->typeworkattendant2);
      $formAdmission->empresaacudiente2 = $this->upper($nombreEmpresaAcudiente2);
      $formAdmission->direccionempresaacudiente2 = $this->upper($direccionEmpresaAcudiente2);
      $formAdmission->ciudadempresaacudiente2 = trim($request->citybussinessattendant2);
      $formAdmission->barrioempresaacudiente2 = trim($request->barrioempresaattendant2);
      $formAdmission->localidadempresaacudiente2 = trim($request->localidadempresaattendant2);
      $formAdmission->cargoempresaacudiente2 = $this->upper($cargoAcudiente2);
      $formAdmission->fechaingresoempresaacudiente2 = $datefechaingresoaudiente2;
      $formAdmission->rhacu2 = trim($request->bloodtypeattendant2);
      $formAdmission->sexoacudiente2 = trim($request->sexattendant2);
      $formAdmission->nombreemergencia = $this->ucwords($request->nameemergency);
      $formAdmission->documentoemergencia = trim($request->documentemergency);
      $formAdmission->direccionemergencia = $this->upper($request->addressemergency);
      $formAdmission->barrioemergencia = trim($request->barrioemergency);
      $formAdmission->localidademergencia = trim($request->localidademergency);
      $formAdmission->celularemergencia = trim($request->celularemergency);
      $formAdmission->whatsappemergencia = trim($request->whatsappemergency);
      $formAdmission->parentescoemergencia = $this->fu($request->relationemergency);
      $formAdmission->correoemergencia = $this->lower($request->emailemergency);
      $formAdmission->nombreautorizado1 = $this->ucwords($request->nameautorized1);
      $formAdmission->documentoautorizado1 = trim($request->documentautorized1);
      $formAdmission->parentescoautorizado1 = trim($request->relationautorized1);
      $formAdmission->nombreautorizado2 = $this->ucwords($request->nameautorized2);
      $formAdmission->documentoautorizado2 = trim($request->documentautorized2);
      $formAdmission->parentescoautorizado2 = trim($request->relationautorized2);
      $formAdmission->fechaingreso = $datefechaingreso;
      $formAdmission->expectatives_likechild = $this->fu($request->expectatives_likechild);
      $formAdmission->expectatives_activityschild = $this->fu($request->expectatives_activityschild);
      $formAdmission->expectatives_toychild = $this->fu($request->expectatives_toychild);
      $formAdmission->expectatives_aspectchild = $this->fu($request->expectatives_aspectchild);
      $formAdmission->expectatives_dreamforchild = $this->fu($request->expectatives_dreamforchild);
      $formAdmission->expectatives_learnchild = $this->fu($request->expectatives_learnchild);
      $formAdmission->cultural_eventfamily = $this->fu($request->cultural_eventfamily);
      $formAdmission->cultural_supportculturefamily = $this->fu($request->cultural_supportculturefamily);
      $formAdmission->cultural_gardenlearnculture = $this->fu($request->cultural_gardenlearnculture);
      $formAdmission->cultural_shareculturefamily = $this->fu($request->cultural_shareculturefamily);
      $formAdmission->periodo_escolar = trim($request->school_period);
      $formAdmission->save();

      return redirect()->route('registerAdmission')->with('SuccessAdmission', 'Se ha registrado el formulario para el ni??o/ni??a (' . $formAdmission->nombres . ' '  . $formAdmission->apellidos . ') con n??mero de documento (' . $formAdmission->numerodocumento . '), CORRECTAMENTE!!');
    } else {
      $search = Formadmission::find($validateform->fmId);
      // $namephoto = "photodefault.png";
      if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        // $name = $rut->getClientOriginalName();
        $extension = $photo->extension();
        Storage::disk('kindersoft')->putFileAs('admisiones/fotosaspirantes/', $photo, trim($request->numberdocument) . '_photo.' . $extension);
        $namephoto = trim($request->numberdocument) . '_photo.' . $extension;
      }
      $datefechanacimiento = Date('Y-m-d', strtotime(
        trim($request->year) . '-' . trim($request->month) . '-' . trim($request->day)
      ));
      $datefechaingreso = Date('Y-m-d', strtotime(
        trim($request->yearentry) . '-' . trim($request->monthentry) . '-' . trim($request->dayentry)
      ));
      $datefechaingresoaudiente1 = Date('Y-m-d', strtotime(trim($request->dateentryattendant1)));
      $datefechaingresoaudiente2 = Date('Y-m-d', strtotime(trim($request->dateentryattendant2)));

      $search->foto = $namephoto;
      $search->nombres = $this->upper($nombreAlumno);
      $search->apellidos = $this->upper($apellidoAlumno);
      $search->genero = $this->upper($request->gender);
      $search->fechanacimiento = $datefechanacimiento;
      $search->tipodocumento = trim($request->typedocument);
      $search->numerodocumento = trim($request->numberdocument);
      $search->nacionalidad = $this->upper($nacionalidad);
      $search->mesesgestacion = trim($request->monthbord);
      $search->tiposangre = trim($request->bloodtype);
      $search->tipoparto = trim($request->typebord);
      $search->enfermedades = $this->fu($request->healthbad);
      $search->tratamientos = $this->fu($request->medical);
      $search->alergias = $this->fu($request->descripcionalergias);
      $search->asistenciaterapias = trim($request->terapia);
      $search->cual = $this->fu($request->whatterapia);
      $search->health = trim($request->health);
      $search->programa = trim($request->typeprogram);
      $search->numerohermanos = trim($request->brothers);
      $search->lugarqueocupa = trim($request->placebrother);
      $search->lugarqueocupa = trim($request->placebrother);
      $search->conquienvive = $this->upper($request->withlive);
      $search->otroscuidados = $this->fu($request->other);
      $search->nombreacudiente1 = $this->ucwords($request->nameattendant1);
      $search->documentoacudiente1 = trim($request->documentattendant1);
      $search->docacu1 = trim($request->typedocumentattendant1);
      $search->direccionacudiente1 = trim($direccionAcudiente1);
      $search->barrioacudiente1 = trim($request->barrioattendant1);
      $search->localidadacudiente1 = trim($request->localidadattendant1);
      $search->celularacudiente1 = trim($request->celularattendant1);
      $search->celularacudiente1 = trim($request->celularattendant1);
      $search->whatsappacudiente1 = trim($request->whatsappattendant1);
      $search->correoacudiente1 = $this->lower($request->emailattendant1);
      $search->formacionacudiente1 = trim($formacionAcudiente1);
      $search->tituloacudiente1 = $this->upper($tituloAcudiente1);
      $search->tipoocupacionacudiente1 = trim($request->typeworkattendant1);
      $search->empresaacudiente1 = $this->upper($nombreEmpresaAcudiente1);
      $search->direccionempresaacudiente1 = $this->upper($direccionEmpresaAcudiente1);
      $search->ciudadempresaacudiente1 = trim($request->citybussinessattendant1);
      $search->barrioempresaacudiente1 = trim($request->barrioempresaattendant1);
      $search->localidadempresaacudiente1 = trim($request->localidadempresaattendant1);
      $search->cargoempresaacudiente1 = $this->upper($cargoAcudiente1);
      $search->fechaingresoempresaacudiente1 = $datefechaingresoaudiente1;
      $search->rhacu1 = trim($request->bloodtypeattendant1);
      $search->sexoacudiente1 = trim($request->sexattendant1);
      $search->nombreacudiente2 = $this->ucwords($request->nameattendant2);
      $search->documentoacudiente2 = trim($request->documentattendant2);
      $search->docacu2 = trim($request->typedocumentattendant2);
      $search->direccionacudiente2 = trim($direccionAcudiente2);
      $search->barrioacudiente2 = trim($request->barrioattendant2);
      $search->localidadacudiente2 = trim($request->localidadattendant2);
      $search->celularacudiente2 = trim($request->celularattendant2);
      $search->whatsappacudiente2 = trim($request->whatsappattendant2);
      $search->correoacudiente2 = $this->lower($request->emailattendant2);
      $search->formacionacudiente2 = trim($formacionAcudiente2);
      $search->tituloacudiente2 = $this->upper($tituloAcudiente2);
      $search->tipoocupacionacudiente2 = trim($request->typeworkattendant2);
      $search->empresaacudiente2 = $this->upper($nombreEmpresaAcudiente2);
      $search->direccionempresaacudiente2 = $this->upper($direccionEmpresaAcudiente2);
      $search->ciudadempresaacudiente2 = trim($request->citybussinessattendant2);
      $search->barrioempresaacudiente2 = trim($request->barrioempresaattendant2);
      $search->localidadempresaacudiente2 = trim($request->localidadempresaattendant2);
      $search->cargoempresaacudiente2 = $this->upper($cargoAcudiente2);
      $search->fechaingresoempresaacudiente2 = $datefechaingresoaudiente2;
      $search->rhacu2 = trim($request->bloodtypeattendant2);
      $search->sexoacudiente2 = trim($request->sexattendant2);
      $search->nombreemergencia = $this->ucwords($request->nameemergency);
      $search->documentoemergencia = trim($request->documentemergency);
      $search->direccionemergencia = $this->upper($request->addressemergency);
      $search->barrioemergencia = trim($request->barrioemergency);
      $search->localidademergencia = trim($request->localidademergency);
      $search->celularemergencia = trim($request->celularemergency);
      $search->whatsappemergencia = trim($request->whatsappemergency);
      $search->parentescoemergencia = $this->fu($request->relationemergency);
      $search->correoemergencia = $this->lower($request->emailemergency);
      $search->nombreautorizado1 = $this->ucwords($request->nameautorized1);
      $search->documentoautorizado1 = trim($request->documentautorized1);
      $search->parentescoautorizado1 = trim($request->relationautorized1);
      $search->nombreautorizado2 = $this->ucwords($request->nameautorized2);
      $search->documentoautorizado2 = trim($request->documentautorized2);
      $search->parentescoautorizado2 = trim($request->relationautorized2);
      $search->fechaingreso = $datefechaingreso;
      $search->expectatives_likechild = $this->fu($request->expectatives_likechild);
      $search->expectatives_activityschild = $this->fu($request->expectatives_activityschild);
      $search->expectatives_toychild = $this->fu($request->expectatives_toychild);
      $search->expectatives_aspectchild = $this->fu($request->expectatives_aspectchild);
      $search->expectatives_dreamforchild = $this->fu($request->expectatives_dreamforchild);
      $search->expectatives_learnchild = $this->fu($request->expectatives_learnchild);
      $search->cultural_eventfamily = $this->fu($request->cultural_eventfamily);
      $search->cultural_supportculturefamily = $this->fu($request->cultural_supportculturefamily);
      $search->cultural_gardenlearnculture = $this->fu($request->cultural_gardenlearnculture);
      $search->cultural_shareculturefamily = $this->fu($request->cultural_shareculturefamily);
      $search->status = "PENDIENTE";
      $search->migracion = 0;
      $search->periodo_escolar = trim($request->school_period);
      $search->save();

      return redirect()->route('registerAdmission')->with('SuccessAdmission', 'Se ha registrado el formulario para el ni??o/ni??a (' . $search->nombres . ' '  . $search->apellidos . ') con n??mero de documento (' . $search->numerodocumento . '), CORRECTAMENTE!!');
    }
  }

  function aprovedTo()
  {
    $eps = Health::where('type', 'EPS')->get();
    $pre = Health::where('type', 'PREPAGADA')->orWhere('entity', 'NO REPORTA')->get();
    $forms = Formadmission::where('status', 'PENDIENTE')->get();
    $citys = City::all();
    $healths = Health::all();
    $locations = Location::all();
    $bloodtypes = Bloodtype::all();
    return view('modules.admissionModule.aproved', compact('forms', 'eps', 'pre', 'bloodtypes', 'healths', 'locations', 'citys'));
  }

  function updateAdmission(Request $request)
  {
    // dd($request->all());
    /*
            $request->firstname
            $request->lastname
            $request->day
            $request->month
            $request->year
            $request->typedocument
            $request->numberdocument
            $request->nationality
            $request->monthbord
            $request->bloodtype
            $request->typebord
            $request->healthbad
            $request->medical
            $request->descripcionalergias
            $request->terapia
            $request->whatterapia
            $request->eps
            $request->prepagada
            $request->typeprogram
            $request->brothers
            $request->placebrother
            $request->withlive
            $request->other
            $request->nameattendant1
            $request->documentattendant1
            $request->addressattendant1
            $request->barrioattendant1
            $request->localidadattendant1
            $request->celularattendant1
            $request->whatsappattendant1
            $request->emailattendant1
            $request->typeprofessionattendant1
            $request->tituloattendant1
            $request->typeworkattendant1
            $request->bussinessattendant1
            $request->addressbussinessattendant1
            $request->citybussinessattendant1
            $request->barrioempresaattendant1
            $request->localidadempresaattendant1
            $request->positionattendant1
            $request->dateentryattendant1
            $request->nameattendant2
            $request->documentattendant2
            $request->addressattendant2
            $request->barrioattendant2
            $request->localidadattendant2
            $request->celularattendant2
            $request->whatsappattendant2
            $request->emailattendant2
            $request->typeprofessionattendant2
            $request->tituloattendant2
            $request->typeworkattendant2
            $request->bussinessattendant2
            $request->addressbussinessattendant2
            $request->citybussinessattendant2
            $request->barrioempresaattendant2
            $request->localidadempresaattendant2
            $request->positionattendant2
            $request->dateentryattendant2
            $request->nameemergency
            $request->documentemergency
            $request->addressemergency
            $request->barrioemergency
            $request->localidademergency
            $request->celularemergency
            $request->whatsappemergency
            $request->relationemergency
            $request->emailemergency
            $request->nameautorized1
            $request->documentautorized1
            $request->relationautorized1
            $request->nameautorized2
            $request->documentautorized2
            $request->relationautorized2
            $request->dayentry
            $request->monthentry
            $request->yearentry
            $request->fmId_Edit
            $request->expectatives_likechild
            $request->expectatives_activityschild
            $request->expectatives_toychild
            $request->expectatives_aspectchild
            $request->expectatives_dreamforchild
            $request->expectatives_learnchild
            $request->cultural_eventfamily
            $request->cultural_supportculturefamily
            $request->cultural_gardenlearnculture
            $request->cultural_shareculturefamily
        */
    $validateform = Formadmission::where('numerodocumento', trim($request->numberdocument))->where('fmId', '!=', trim($request->fmId_Edit))->first();
    if ($validateform == null) {
      $validate = Formadmission::find(trim($request->fmId_Edit));
      if ($validate != null) {
        if (!isset($request->notphoto)) {
          if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            // $name = $rut->getClientOriginalName();
            $extension = $photo->extension();
            if ($validate->foto != 'photodefault.png') {
              Storage::disk('kindersoft')->delete('admisiones/fotosaspirantes/' . $validate->foto);
            }
            Storage::disk('kindersoft')->putFileAs('admisiones/fotosaspirantes/', $photo, trim($request->numberdocument) . '_photo.' . $extension);
            $namephoto = trim($request->numberdocument) . '_photo.' . $extension;
          } else {
            if ($validate->numerodocumento != trim($request->numberdocument) && $validate->foto != 'photodefault.png') {
              $namephoto = trim($request->numberdocument) . '_photo.jpg';
              if ($validate->foto != $namephoto) {
                Storage::disk('kindersoft')->move('admisiones/fotosaspirantes/' . $validate->foto, 'admisiones/fotosaspirantes/' . $namephoto);
              }
            } else {
              $namephoto = $validate->foto;
            }
          }
        } else {
          if ($validate->foto != 'photodefault.png') {
            Storage::disk('kindersoft')->delete('admisiones/fotosaspirantes/' . $validate->foto);
          }
          $namephoto = 'photodefault.png';
        }
        $datefechanacimiento = Date('Y-m-d', strtotime(
          trim($request->year) . '-' . trim($request->month) . '-' . trim($request->day)
        ));
        $datefechaingreso = Date('Y-m-d', strtotime(
          trim($request->yearentry) . '-' . trim($request->monthentry) . '-' . trim($request->dayentry)
        ));
        $datefechaingresoaudiente1 = Date('Y-m-d', strtotime(trim($request->dateentryattendant1)));
        $datefechaingresoaudiente2 = Date('Y-m-d', strtotime(trim($request->dateentryattendant2)));
        $validate->foto = $namephoto;
        $validate->nombres = $this->upper($request->firstname);
        $validate->apellidos = $this->upper($request->lastname);
        $validate->genero = $this->upper($request->gender);
        $validate->fechanacimiento = $datefechanacimiento;
        $validate->tipodocumento = trim($request->typedocument);
        $validate->numerodocumento = trim($request->numberdocument);
        $validate->nacionalidad = $this->upper($request->nationality);
        $validate->mesesgestacion = trim($request->monthbord);
        $validate->tiposangre = trim($request->bloodtype);
        $validate->tipoparto = trim($request->typebord);
        $validate->enfermedades = $this->fu($request->healthbad);
        $validate->tratamientos = $this->fu($request->medical);
        $validate->alergias = $this->fu($request->descripcionalergias);
        $validate->asistenciaterapias = trim($request->terapia);
        $validate->cual = $this->fu($request->whatterapia);
        $validate->health = trim($request->health);
        $validate->programa = trim($request->typeprogram);
        $validate->numerohermanos = trim($request->brothers);
        $validate->lugarqueocupa = trim($request->placebrother);
        $validate->conquienvive = $this->upper($request->withlive);
        $validate->otroscuidados = $this->fu($request->other);
        $validate->nombreacudiente1 = $this->ucwords($request->nameattendant1);
        $validate->documentoacudiente1 = trim($request->documentattendant1);
        $validate->direccionacudiente1 = trim($request->addressattendant1);
        $validate->barrioacudiente1 = trim($request->barrioattendant1);
        $validate->localidadacudiente1 = trim($request->localidadattendant1);
        $validate->celularacudiente1 = trim($request->celularattendant1);
        $validate->whatsappacudiente1 = trim($request->whatsappattendant1);
        $validate->correoacudiente1 = $this->lower($request->emailattendant1);
        $validate->formacionacudiente1 = trim($request->typeprofessionattendant1);
        $validate->tituloacudiente1 = $this->upper($request->tituloattendant1);
        $validate->tipoocupacionacudiente1 = trim($request->typeworkattendant1);
        $validate->empresaacudiente1 = $this->upper($request->bussinessattendant1);
        $validate->direccionempresaacudiente1 = $this->upper($request->addressbussinessattendant1);
        $validate->ciudadempresaacudiente1 = trim($request->citybussinessattendant1);
        $validate->barrioempresaacudiente1 = trim($request->barrioempresaattendant1);
        $validate->localidadempresaacudiente1 = trim($request->localidadempresaattendant1);
        $validate->cargoempresaacudiente1 = $this->upper($request->positionattendant1);
        $validate->fechaingresoempresaacudiente1 = $datefechaingresoaudiente1;
        $validate->nombreacudiente2 = $this->ucwords($request->nameattendant2);
        $validate->documentoacudiente2 = trim($request->documentattendant2);
        $validate->direccionacudiente2 = trim($request->addressattendant2);
        $validate->barrioacudiente2 = trim($request->barrioattendant2);
        $validate->localidadacudiente2 = trim($request->localidadattendant2);
        $validate->celularacudiente2 = trim($request->celularattendant2);
        $validate->whatsappacudiente2 = trim($request->whatsappattendant2);
        $validate->correoacudiente2 = $this->lower($request->emailattendant2);
        $validate->formacionacudiente2 = trim($request->typeprofessionattendant2);
        $validate->tituloacudiente2 = $this->upper($request->tituloattendant2);
        $validate->tipoocupacionacudiente2 = trim($request->typeworkattendant2);
        $validate->empresaacudiente2 = $this->upper($request->bussinessattendant2);
        $validate->direccionempresaacudiente2 = $this->upper($request->addressbussinessattendant2);
        $validate->ciudadempresaacudiente2 = trim($request->citybussinessattendant2);
        $validate->barrioempresaacudiente2 = trim($request->barrioempresaattendant2);
        $validate->localidadempresaacudiente2 = trim($request->localidadempresaattendant2);
        $validate->cargoempresaacudiente2 = $this->upper($request->positionattendant2);
        $validate->fechaingresoempresaacudiente2 = $datefechaingresoaudiente2;
        $validate->nombreemergencia = $this->ucwords($request->nameemergency);
        $validate->documentoemergencia = trim($request->documentemergency);
        $validate->direccionemergencia = $this->upper($request->addressemergency);
        $validate->barrioemergencia = trim($request->barrioemergency);
        $validate->localidademergencia = trim($request->localidademergency);
        $validate->celularemergencia = trim($request->celularemergency);
        $validate->whatsappemergencia = trim($request->whatsappemergency);
        $validate->parentescoemergencia = $this->fu($request->relationemergency);
        $validate->correoemergencia = $this->lower($request->emailemergency);
        $validate->nombreautorizado1 = $this->ucwords($request->nameautorized1);
        $validate->documentoautorizado1 = trim($request->documentautorized1);
        $validate->parentescoautorizado1 = trim($request->relationautorized1);
        $validate->nombreautorizado2 = $this->ucwords($request->nameautorized2);
        $validate->documentoautorizado2 = trim($request->documentautorized2);
        $validate->parentescoautorizado2 = trim($request->relationautorized2);
        $validate->fechaingreso = $datefechaingreso;
        $validate->expectatives_likechild = $this->fu($request->expectatives_likechild);
        $validate->expectatives_activityschild = $this->fu($request->expectatives_activityschild);
        $validate->expectatives_toychild = $this->fu($request->expectatives_toychild);
        $validate->expectatives_aspectchild = $this->fu($request->expectatives_aspectchild);
        $validate->expectatives_dreamforchild = $this->fu($request->expectatives_dreamforchild);
        $validate->expectatives_learnchild = $this->fu($request->expectatives_learnchild);
        $validate->cultural_eventfamily = $this->fu($request->cultural_eventfamily);
        $validate->cultural_supportculturefamily = $this->fu($request->cultural_supportculturefamily);
        $validate->cultural_gardenlearnculture = $this->fu($request->cultural_gardenlearnculture);
        $validate->cultural_shareculturefamily = $this->fu($request->cultural_shareculturefamily);
        $namechild = $this->upper($request->firstname) . ' ' . $this->upper($request->lastname);
        $numberchild = $this->upper($request->firstname) . ' ' . $this->upper($request->lastname);
        $validate->save();
        return redirect()->route('aprovedAdmission')->with('PrimaryForm', 'Se ha actualizado el formulario para el ni??o/ni??a (' . $namechild . ') con n??mero de documento (' . $numberchild . '), CORRECTAMENTE!!');
      } else {
        return redirect()->route('aprovedAdmission')->with('SecondaryForm', 'No se encuentra el formulario con el n??mero de documento (' . trim($request->numberdocument) . ')');
      }
    } else {
      return redirect()->route('aprovedAdmission')->with('SecondaryForm', 'Ya existe un formulario con el n??mero de documento (' . trim($request->numberdocument) . ') del ni??o/ni??a ingresado');
    }
  }

  function saveaprovedAdmission(Request $request)
  {
    // dd($request->all());
    $validate = Formadmission::find(trim($request->fmId));
    if ($validate != null) {
      $name = $validate->nombres . ' ' . $validate->apellidos;
      $validate->status = 'APROBADA';
      $validate->save();
      return redirect()->route('aprovedAdmission')->with('PrimaryForm', 'Formulario de ni??o/ni??a (' . $name . '), APROBADO!!, consulte en ADMISIONES >> MIGRACION FORMULARIO');
    } else {
      return redirect()->route('aprovedAdmission')->with('SecondaryForm', 'No se encuentra el formulario, intentelo nuevamente');
    }
  }

  function deleteAdmission(Request $request)
  {
    // dd($request->all());
    $validate = Formadmission::find(trim($request->fmId_Delete));
    if ($validate != null) {
      $name = $validate->nombres . ' ' . $validate->apellidos;
      if ($validate->foto != 'photodefault.png') {
        Storage::disk('kindersoft')->delete('admisiones/fotosaspirantes/' . $validate->foto);
      }
      $validate->delete();
      return redirect()->route('aprovedAdmission')->with('WarningForm', 'Formulario de ni??o/ni??a (' . $name . '), eliminado');
    } else {
      return redirect()->route('aprovedAdmission')->with('SecondaryForm', 'No se encuentra el formulario, intentelo nuevamente');
    }
  }

  /**
   * ADMISIONES > MIGRACION FORMULARIOS
   */
  function filesTo()
  {
    $forms = Formadmission::where([
      ['status', '=', 'APROBADA'],
      ['migracion', '=', '0']
    ])->get();
    return view('modules.admissionModule.files', compact('forms'));
  }

  /**
   * ADMISIONES > ARCHIVO FORMULARIOS
   */
  function filesTofiles()
  {
    // $consulta = DB::table('record_archives')->select('record_archives.nombres as nombres','record_archives.apellidos as apellidos','record_archives.numerodocumento as documento','record_archives.periodo_escolar as periodo','record_archives.nombreacudiente1 as acudiente_1','record_archives.celularacudiente1 as contacto_1','record_archives.nombreacudiente2 as acudiente_2','record_archives.celularacudiente2 as contacto_2')->get();

    // dd($consulta);
    return view('modules.admissionModule.filesAdmission');
  }

  public function filesServerSide(Request $request)
  {
    ini_set('max_execution_set',0);
    ini_set('memory_limit', '-1');

    $columns = array(
      0 => 'nombres',
      1 => 'documento',
      2 => 'periodo',
      3 => 'acudiente_1',
      4 => 'contacto_1',
      5 => 'acudiente_2',
      6 => 'contacto_2',
      7 => 'action'
    );

    /**
     * Consulta de Datos
     */
    $consulta = DB::table('record_archives')->select('record_archives.nombres as nombres', 'record_archives.apellidos as apellidos','record_archives.numerodocumento as documento','record_archives.nombreacudiente1 as acudiente_1','record_archives.celularacudiente1 as contacto_1','record_archives.nombreacudiente2 as acudiente_2','record_archives.celularacudiente2 as contacto_2','record_archives.periodo_escolar as periodo','record_archives.id as id');

    /**
     * Totales Datatable
     */
    $totalData = $consulta->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $posts = $consulta->offset($start)->limit($limit)->orderBy($order,$dir)->get();
      $totalFiltered = $totalData;
    } else {
      $search = $request->input('search.value');
      $clausulas = $consulta->where("record_archives.nombres", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.apellidos", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.nombreacudiente1", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.nombreacudiente2", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.numerodocumento", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.celularacudiente1", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.celularacudiente2", "like","%{$search}%");
      $clausulas = $consulta->orWhere("record_archives.periodo_escolar", "like","%{$search}%");

      $totalFiltered = $clausulas->count();
      $posts = $clausulas->offset($start)->limit($limit)->orderBy($order,$dir)->get();
    }

    /**
     * Array de los Datos
     */

     $data = array();
     if ($posts) {
      foreach ($posts as $key => $register) {
        $nestedData['nombres'] = $register->nombres." ".$register->apellidos;
        $nestedData['documento'] = $register->documento;
        $nestedData['periodo'] = $register->periodo;
        $nestedData['acudiente_1'] = $register->acudiente_1;
        $nestedData['contacto_1'] = $register->contacto_1;
        $nestedData['acudiente_2'] = $register->acudiente_2;
        $nestedData['contacto_2'] = $register->contacto_2;
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

  function pdfAdmission(Request $request)
  {
    // dd($request->all());
    // dd($request->fmId);
    $form = RecordArchive::find($request->id);
    if ($form != null) {
      $date = Carbon::now('-05:00');
      $dateborn = explode('-', $form->fechanacimiento);
      $dateentry = explode('-', $form->fechaingreso);
      $health = Health::find($form->health);
      $districtattendant1 = District::find($form->barrioacudiente1);
      $locationattendant1 = Location::find($form->localidadacudiente1);
      $citybussinessattendant1 = City::find($form->ciudadempresaacudiente1);
      $districtbussinessattendant1 = District::find($form->barrioempresaacudiente1);
      $locationbussinessattendant1 = Location::find($form->localidadempresaacudiente1);
      $districtattendant2 = District::find($form->barrioacudiente2);
      $locationattendant2 = Location::find($form->localidadacudiente2);
      $citybussinessattendant2 = City::find($form->ciudadempresaacudiente2);
      $districtbussinessattendant2 = District::find($form->barrioempresaacudiente2);
      $locationbussinessattendant2 = Location::find($form->localidadempresaacudiente2);
      $districtemergency = District::find($form->barrioemergencia);
      $locationemergency = Location::find($form->localidademergencia);
      $garden = Garden::first();
      $namefile = 'Formulario de matr??cula de ni??o/ni??a (' . $form->nombres . ' ' . $form->apellidos . ') descargado el ' . $date . '.pdf';
      $pdf = App::make('dompdf.wrapper');
      $pdf->loadView('modules.admissionModule.formPdf', compact(
        'form',
        'dateborn',
        'dateentry',
        'health',
        'districtattendant1',
        'locationattendant1',
        'citybussinessattendant1',
        'districtbussinessattendant1',
        'locationbussinessattendant1',
        'districtattendant2',
        'locationattendant2',
        'citybussinessattendant2',
        'districtbussinessattendant2',
        'locationbussinessattendant2',
        'districtemergency',
        'locationemergency',
        'garden'
      ));
      return $pdf->download($namefile);
    } else {
      return redirect()->route('filesAdmission')->with('SecondaryForm', 'No se encuentran el formulario pdf');
    }
  }

  /**
   * MIGRACION DE INFORMACION A LAS TABLAS ACUDIENTE, AUTORIZADO, ESTUDIANTE Y ARCHIVO 
   */
  function migrationAdmission(Request $request)
  {
    $dates = trim($request->json_migration);
    // dd($dates);
    $tranfers = explode('|||', trim($request->json_migration));
    // dd($request->fmId_migration);  
    $form = Formadmission::find(trim($request->fmId_migration));
    if ($form != null) {
      $relations = array();
      for ($r = 1; $r < count($tranfers); $r++) {
        $items = array();
        if ($tranfers[$r] != 'null') {
          $dates = explode('|=|', $tranfers[$r]);
          for ($i = 0; $i < count($dates); $i++) {
            $columns = explode('==>', $dates[$i]);
            if (count($columns) == 2) {
              array_push($items, [
                $columns[0],
                $columns[1]
              ]);
            } else if (count($columns) == 3) {
              array_push($items, [
                $columns[0],
                $columns[1],
                $columns[2]
              ]);
            }
          }
        }
        // else{
        //     array_push($items,null);
        // }
        if (count($items) > 0) {
          array_push($relations, $items);
        }
      }
      $address = \explode('|=|', $tranfers[3]);
      $addressString = \explode('==>', $address[3]);
      $location = \explode('|=|', $tranfers[3]);
      $locationString = explode('==>', $location[5]);
      $district = \explode('|=|', $tranfers[3]);
      $districtString = \explode('==>', $district[4]);
      $city = \explode('|=|', $tranfers[3]);
      $cityString = \explode('==>', $city[14]);
      // 1027298777
      $msjMigration = '';
      for ($m = 0; $m < count($relations); $m++) {

        if ($relations[$m][0] != null) {
          switch ($m) {
            case 0: // INSERT/UPDATE STUDENT MIGRATION
              $student = Student::find($request->sId_migration);
              if ($student != null) {
                $findDefault = strpos(trim($relations[$m][1][1]), 'default');
                if (!$findDefault) {
                  // Storage::disk('kindersoft')->move(old,new);
                  $extension = explode('.', trim($relations[$m][1][1]));
                  $exits = Storage::disk('kindersoft')->exists('admisiones/fotoaspirantes/' . $relations[$m][1][1]);
                  if ($exits) {
                    Storage::disk('kindersoft')->move('admisiones/fotosaspirantes/' . $relations[$m][1][1], 'students/' . $relations[$m][3][1] . '_photo.jpg');
                  }
                  // $photo = Storage::get('admisiones/fotosaspirantes/'.trim($relations[$m][1][1]));
                  // Storage::disk('kindersoft')->putFileAs('students/',$photo,trim($student->numberdocument) . '_photo.' . $extension);
                  // $student->photo = trim($relations[$m][1][1]) . '_photo.' . $extension;
                }

                $typeId = (int)$relations[$m][2][1];
                if ($student->typedocument_id != $typeId) {
                  $typedocument = Document::find($typeId);
                  if ($typedocument != null) {
                    $student->typedocument_id = $typeId;
                  }
                }

                // $student->typedocument_id = $relations[$m][2][1];
                // $student->numberdocument = $relations[$m][3][1];

                $fechaBirth = date('Y-m-d', strtotime($relations[$m][4][1]));
                $student->birthdate = $fechaBirth;
                $student->yearsold = trim($relations[$m][4][2]);

                $names = explode('|', $relations[$m][5][2]);
                $student->firstname = $names[0];
                $student->threename = $names[1];
                $student->fourname = (isset($names[2])) ? $names[2] : $student->fourname;
                $bloodId = (int)$relations[$m][6][1];
                if ($student->bloodtype_id != $bloodId) {
                  $bloodtype = Bloodtype::find($bloodId);
                  if ($bloodtype != null) {
                    $student->bloodtype_id = $bloodId;
                  }
                }
                if ($relations[$m][7][1] == 'MASCULINO' || $relations[$m][7][1] == 'FEMENINO' || $relations[$m][7][1] == 'INDEFINIDO') {
                  $student->gender = $relations[$m][7][1];
                }
                $healthId = (int)$relations[$m][8][1];
                if ($student->health_id != $healthId) {
                  $health = Health::find($healthId);
                  if ($health != null) {
                    $student->health_id = $healthId;
                  }
                }
                $student->additionalHealt = mb_strtoupper($relations[$m][9][1]);
                $student->additionalHealtDescription = trim($relations[$m][10][1]);
                $student->address = trim($addressString[1]);
                $student->locationhome_id = trim($locationString[1]);
                $student->dictricthome_id = \trim($districtString[1]);
                $student->cityhome_id = \trim($cityString[1]);
                // CAMPOS SIN ACTUALIZAR
                $student->save();
                $msjMigration .= 'ALUMNO --> Datos actualizados ';
              } else {
                $namephoto = 'studentdefault.png';
                $findDefault = strpos(trim($relations[$m][1][1]), 'default');
                if (!$findDefault) {
                  // Storage::disk('kindersoft')->move(old,new);
                  $extension = explode('.', trim($relations[$m][1][1]));
                  $exits = Storage::disk('kindersoft')->exists('admisiones/fotoaspirantes/' . $relations[$m][1][1]);
                  if ($exits) {
                    Storage::disk('kindersoft')->move('admisiones/fotosaspirantes/' . $relations[$m][1][1], 'students/' . $relations[$m][3][1] . '_photo.jpg');
                  }
                  // $photo = Storage::get('admisiones/fotosaspirantes/'.trim($relations[$m][1][1]));
                  // Storage::disk('kindersoft')->putFileAs('students/',$photo,trim($student->numberdocument) . '_photo.' . $extension);
                  // $namephoto = trim($relations[$m][1][1]) . '_photo.' . $extension;
                }
                $typedocument_id = 6; // Registro de NUIP
                $typeId = (int)$relations[$m][2][1];
                $typedocument = Document::find($typeId);
                if ($typedocument != null) {
                  $typeId_document = $typeId;
                }

                $names = explode('|', $relations[$m][5][2]);
                $fechaBirth = date('Y-m-d', strtotime($relations[$m][4][1]));
                $yearsold = trim($relations[$m][4][2]);

                $bloodtype_id = 9; // Registro de NO REPORTADA
                $bloodId = (int)$relations[$m][6][1];
                $bloodtype = Bloodtype::find($bloodId);
                if ($bloodtype != null) {
                  $bloodtype_id = $bloodId;
                }

                $gender = 'INDEFINIDO';
                if ($relations[$m][7][1] == 'MASCULINO' || $relations[$m][7][1] == 'FEMENINO' || $relations[$m][7][1] == 'INDEFINIDO') {
                  $gender = $relations[$m][7][1];
                }

                $health_id = null;
                $healthId = (int)$relations[$m][8][1];
                $health = Health::find($healthId);
                if ($health != null) {
                  $health_id = $healthId;
                }

                Student::updateOrCreate([
                  'typedocument_id' => $typedocument_id,
                  'numberdocument' => $relations[$m][3][1],
                  'photo' => $namephoto,
                  'firstname' => mb_strtoupper(trim($names[0])),
                  'threename' => mb_strtoupper(trim($names[1])),
                  'fourname' => (isset($names[2])) ? $names[2] : null,
                  'birthdate' => $fechaBirth,
                  'yearsold' => $yearsold,
                  'address' => trim($addressString[1]),
                  'cityhome_id' => \trim($cityString[1]),
                  'locationhome_id' => trim($locationString[1]),
                  'dictricthome_id' => \trim($districtString[1]),
                  'bloodtype_id' => $bloodtype_id,
                  'gender' => $gender,
                  'health_id' => $health_id,
                  'additionalHealt' => mb_strtoupper($relations[$m][9][1]),
                  'additionalHealtDescription' => trim($relations[$m][10][1])
                ]);

                $msjMigration .= 'ALUMNO --> Datos creados ';
              }
              break;
          }
        }
      }

      $MotherFather = Formadmission::where('fmId', $request->fmId_migration)->first();

      // dd($request->json_dataAttendant1, $request->json_dataAttendant2);
      $dataFather = \mb_split(',', $request->json_dataAttendant1);
      $dataMother = \mb_split(',', $request->json_dataAttendant2);

      // dd($dataFather, $dataMother);
      $motherExist = Attendant::where('numberdocument', $dataMother[0])->first();

      $professionMother = Profession::where('title', $dataMother[10])->first();

      if (!$professionMother) {
        Profession::create([
          'title' => $dataMother[10],
        ]);
      }
      $professionMother = Profession::where('title', $dataMother[10])->first();
      $MotherSex = Formadmission::where('documentoacudiente1', $dataMother[0])->value('sexoacudiente1');
      if (!$MotherSex) {
        $MotherSex = Formadmission::where('documentoacudiente2', $dataMother[0])->value('sexoacudiente2');
      }
      if ($motherExist != null) {
        $names = \mb_split("\|", $dataMother[1]);
        try {
          $motherExist->firstname = $this->upper($names[0]);
          $motherExist->threename = $this->upper($names[1]);
        } catch (Exception $e) {
          $motherExist->firstname = $this->upper($names[0]);
        }
        $motherExist->typedocument_id = $MotherFather->docacu2;
        $motherExist->numberdocument = $dataMother[0];
        $motherExist->address = $dataMother[2];
        $motherExist->cityhome_id = $dataMother[3];
        $motherExist->locationhome_id = $dataMother[4];
        $motherExist->dictricthome_id = $dataMother[5];
        $motherExist->phoneone = $dataMother[6];
        $motherExist->whatsapp = $dataMother[7];
        $motherExist->emailone = $dataMother[8];
        $motherExist->bloodtype_id = $MotherFather->rhacu2;
        $motherExist->gender = $MotherSex;
        $motherExist->profession_id = $professionMother->id;
        $motherExist->company = $dataMother[11];
        $motherExist->position = $dataMother[12];
        $motherExist->antiquity = $dataMother[13];
        $motherExist->addresscompany = $dataMother[14];
        $motherExist->citycompany_id = $dataMother[15];
        $motherExist->locationcompany_id = $dataMother[16];
        $motherExist->dictrictcompany_id = $dataMother[17];
        $motherExist->status = $dataMother[18];
        $motherExist->save();
      } else {
        $names = \mb_split("\|", $dataMother[1]);
        Attendant::create([
          "firstname" => $this->upper($names[0]),
          "threename" => (isset($names[1])) ? $this->upper($names[1]) : null,
          "typedocument_id" => $MotherFather->docacu2,
          'numberdocument' => $dataMother[0],
          "address" => $dataMother[2],
          "cityhome_id" => $dataMother[3],
          "locationhome_id" => $dataMother[4],
          "dictricthome_id" => $dataMother[5],
          "phoneone" => $dataMother[6],
          "whatsapp" => $dataMother[7],
          "emailone" => $dataMother[8],
          "bloodtype_id" => $MotherFather->rhacu2,
          "gender" => $MotherSex,
          "profession_id" => $professionMother->id,
          "company" => $dataMother[11],
          "position" => $dataMother[12],
          "antiquity" => $dataMother[13],
          "addresscompany" => $dataMother[14],
          "citycompany_id" => $dataMother[15],
          "locationcompany_id" => $dataMother[16],
          "dictrictcompany_id" => $dataMother[17],
          "status" => $dataMother[18],
        ]);
      }

      $fatherExist = Attendant::where('numberdocument', $dataFather[0])->first();
      $professionFather = Profession::where('title', $dataFather[10])->first();

      if (!$professionFather) {
        Profession::create([
          'title' => $dataFather[10],
        ]);
      }
      $professionFather = Profession::where('title', $dataFather[10])->first();
      $FatherSex = Formadmission::where('documentoacudiente1', $dataFather[0])->value('sexoacudiente1');
      if (!$FatherSex) {
        $FatherSex = Formadmission::where('documentoacudiente2', $dataFather[0])->value('sexoacudiente2');
      }

      if ($fatherExist != null) {
        $names = \mb_split("\|", $dataFather[1]);
        try {
          $fatherExist->firstname = $this->upper($names[0]);
          $fatherExist->threename = $this->upper($names[1]);
        } catch (Exception $e) {
          $fatherExist->firstname = $this->upper($names[0]);
        }
        $motherExist->typedocument_id = $MotherFather->docacu1;
        $fatherExist->numberdocument = $dataFather[0];
        $fatherExist->address = $dataFather[2];
        $fatherExist->cityhome_id = $dataFather[3];
        $fatherExist->locationhome_id = $dataFather[4];
        $fatherExist->dictricthome_id = $dataFather[5];
        $fatherExist->phoneone = $dataFather[6];
        $fatherExist->whatsapp = $dataFather[7];
        $fatherExist->emailone = $dataFather[8];
        $fatherExist->bloodtype_id = $MotherFather->rhacu1;
        $fatherExist->gender = $FatherSex;
        $fatherExist->profession_id = $professionFather->id;
        $fatherExist->company = $dataFather[11];
        $fatherExist->position = $dataFather[12];
        $fatherExist->antiquity = $dataFather[13];
        $fatherExist->addresscompany = $dataFather[14];
        $fatherExist->citycompany_id = $dataFather[15];
        $fatherExist->locationcompany_id = $dataFather[16];
        $fatherExist->dictrictcompany_id = $dataFather[17];
        $fatherExist->status = $dataFather[18];
        $fatherExist->save();
      } else {
        $names = \mb_split("\|", $dataFather[1]);
        Attendant::create([
          "firstname" => $this->upper($names[0]),
          "threename" => (isset($names[1])) ? $this->upper($names[1]) : null,
          "typedocument_id" => $MotherFather->docacu1,
          "numberdocument" => $dataFather[0],
          "address" => $dataFather[2],
          "cityhome_id" => $dataFather[3],
          "locationhome_id" => $dataFather[4],
          "dictricthome_id" => $dataFather[5],
          "phoneone" => $dataFather[6],
          "whatsapp" => $dataFather[7],
          "emailone" => $dataFather[8],
          "bloodtype_id" => $MotherFather->rhacu1,
          "gender" => $FatherSex,
          "profession_id" => ($professionFather->id != null) ? $professionFather->id : "23",
          "company" => $dataFather[11],
          "position" => $dataFather[12],
          "antiquity" => $dataFather[13],
          "addresscompany" => $dataFather[14],
          "citycompany_id" => $dataFather[15],
          "locationcompany_id" => $dataFather[16],
          "dictrictcompany_id" => $dataFather[17],
          "status" => $dataFather[18],
        ]);
      }

      if (config('app.name') == "Colchildren Kindergarten") {
        $DocCC = "7";
      } elseif (config('app.name') == "Dream Home By Creatyvia") {
        $DocCC = "18";
      } else {
        $DocCC = "7";
      }

      $guardian = Formadmission::where('fmId', $request->fmId_migration)->first();

      $validateGuardian = Authorized::where([
        ['autNumberdocument', '=', $guardian->documentoautorizado1],
      ])->first();
      if (!$validateGuardian) {
        // dd('here');
        $lastname = "";
        $namesSplit = \mb_split(' ', $guardian->nombreautorizado1);
        $firstname = Str::ucfirst($namesSplit[0]);
        if (isset($namesSplit[1])) {
          $firstname = Str::ucfirst($namesSplit[0]) . ' ' . Str::ucfirst($namesSplit[1]);
          if (isset($namesSplit[2])) {
            $lastname = Str::ucfirst($namesSplit[2]);
            if (isset($namesSplit[3])) {
              $lastname = Str::ucfirst($namesSplit[2]) . ' ' . Str::ucfirst($namesSplit[3]);
            }
          }
        }
        Authorized::create([
          'autFirstname' => $firstname,
          'autLastname' => $lastname,
          'autDocument_id' => $DocCC,
          'autPhoneone' => $guardian->celularemergencia,
          'autNumberdocument' => $guardian->documentoautorizado1,
          'autRelationship' => $guardian->parentescoautorizado1,
        ]);
      } else {
        $lastname = "";
        $namesSplit = \mb_split(' ', $guardian->nombreautorizado1);
        $firstname = Str::ucfirst($namesSplit[0]);
        if (isset($namesSplit[1])) {
          $firstname = Str::ucfirst($namesSplit[0]) . ' ' . Str::ucfirst($namesSplit[1]);
          if (isset($namesSplit[2])) {
            $lastname = Str::ucfirst($namesSplit[2]);
            if (isset($namesSplit[3])) {
              $lastname = Str::ucfirst($namesSplit[2]) . ' ' . Str::ucfirst($namesSplit[3]);
            }
          }
        }
        $validateGuardian->autFirstname = $firstname;
        $validateGuardian->autLastname = $lastname;
        $validateGuardian->autDocument_id = "7";
        $validateGuardian->autPhoneone = $guardian->celularemergencia;
        $validateGuardian->autNumberdocument = $guardian->documentoautorizado1;
        $validateGuardian->autRelationship = $guardian->parentescoautorizado1;
        $validateGuardian->save();
      }

      if ($guardian->documentoautorizado1 != $guardian->documentoautorizado2) {
        $validateGuardian2 = Authorized::where([
          ['autNumberdocument', '=', $guardian->documentoautorizado2],
        ])->first();

        if (!$validateGuardian2) {
          $lastname = "";
          $namesSplit = \mb_split(' ', $guardian->nombreautorizado2);
          $firstname = Str::ucfirst($namesSplit[0]);
          if (isset($namesSplit[1])) {
            $firstname = Str::ucfirst($namesSplit[0]) . ' ' . Str::ucfirst($namesSplit[1]);
            if (isset($namesSplit[2])) {
              $lastname = Str::ucfirst($namesSplit[2]);
              if (isset($namesSplit[3])) {
                $lastname = Str::ucfirst($namesSplit[2]) . ' ' . Str::ucfirst($namesSplit[3]);
              }
            }
          }

          Authorized::create([
            'autFirstname' => $firstname,
            'autLastname' => $lastname,
            'autDocument_id' => $DocCC,
            'autPhoneone' => $guardian->celularemergencia,
            'autNumberdocument' => $guardian->documentoautorizado2,
            'autRelationship' => $guardian->parentescoautorizado2,
          ]);
        } else {
          $lastname = "";
          $namesSplit = \mb_split(' ', $guardian->nombreautorizado2);
          $firstname = Str::ucfirst($namesSplit[0]);
          if (isset($namesSplit[1])) {
            $firstname = Str::ucfirst($namesSplit[0]) . ' ' . Str::ucfirst($namesSplit[1]);
            if (isset($namesSplit[2])) {
              $lastname = Str::ucfirst($namesSplit[2]);
              if (isset($namesSplit[3])) {
                $lastname = Str::ucfirst($namesSplit[2]) . ' ' . Str::ucfirst($namesSplit[3]);
              }
            }
          }
          $validateGuardian2->autFirstname = $firstname;
          $validateGuardian2->autLastname = $lastname;
          $validateGuardian2->autDocument_id = "7";
          $validateGuardian2->autPhoneone = $guardian->celularemergencia;
          $validateGuardian2->autNumberdocument = $guardian->documentoautorizado2;
          $validateGuardian2->autRelationship = $guardian->parentescoautorizado2;
          $validateGuardian2->save();
        }
      }


      /**
       * Migracion de datos de la tabla formadmission a la tabla de record_archives
       */
      $register = new RecordArchive();
      $register->foto = trim($form->foto);
      $register->nombres = $this->upper($form->nombres);
      $register->apellidos = $this->upper($form->apellidos);
      $register->genero = trim($form->genero);
      $register->fechanacimiento = $form->fechanacimiento;
      $register->tipodocumento = trim($form->tipodocumento);
      $register->numerodocumento = trim($form->numerodocumento);
      $register->nacionalidad = $this->upper($form->nacionalidad);
      $register->mesesgestacion = trim($form->mesesgestacion);
      $register->tiposangre = trim($form->tiposangre);
      $register->tipoparto = trim($form->tipoparto);
      $register->enfermedades = $this->fu($form->enfermedades);
      $register->tratamientos = $this->fu($form->tratamientos);
      $register->alergias = $this->fu($form->alergias);
      $register->asistenciaterapias = trim($form->asistenciaterapias);
      $register->cual = $this->fu($form->cual);
      $register->health = trim($form->health);
      $register->programa = trim($form->programa);
      $register->numerohermanos = trim($form->numerohermanos);
      $register->lugarqueocupa = trim($form->placeblugarqueocuparother);
      $register->conquienvive = $this->upper($form->conquienvive);
      $register->otroscuidados = $this->fu($form->otroscuidados);
      $register->nombreacudiente1 = $this->ucwords($form->nombreacudiente1);
      $register->documentoacudiente1 = trim($form->documentoacudiente1);
      $register->docacu1 = trim($form->docacu1);
      $register->direccionacudiente1 = trim($form->direccionacudiente1);
      $register->barrioacudiente1 = trim($form->barrioacudiente1);
      $register->localidadacudiente1 = trim($form->localidadacudiente1);
      $register->celularacudiente1 = trim($form->celularacudiente1);
      $register->whatsappacudiente1 = trim($form->whatsappacudiente1);
      $register->correoacudiente1 = $this->lower($form->correoacudiente1);
      $register->formacionacudiente1 = trim($form->formacionacudiente1);
      $register->tituloacudiente1 = $this->upper($form->tituloacudiente1);
      $register->tipoocupacionacudiente1 = trim($form->tipoocupacionacudiente1);
      $register->empresaacudiente1 = $this->upper($form->empresaacudiente1);
      $register->direccionempresaacudiente1 = $this->upper($form->direccionempresaacudiente1);
      $register->ciudadempresaacudiente1 = trim($form->ciudadempresaacudiente1);
      $register->barrioempresaacudiente1 = trim($form->barrioempresaacudiente1);
      $register->localidadempresaacudiente1 = trim($form->localidadempresaacudiente1);
      $register->cargoempresaacudiente1 = $this->upper($form->cargoempresaacudiente1);
      $register->fechaingresoempresaacudiente1 = $form->fechaingresoempresaacudiente1;
      $register->rhacu1 = trim($form->rhacu1);
      $register->sexoacudiente1 = trim($form->sexoacudiente1);
      $register->nombreacudiente2 = $this->ucwords($form->nombreacudiente2);
      $register->documentoacudiente2 = trim($form->documentoacudiente2);
      $register->docacu2 = trim($form->docacu2);
      $register->direccionacudiente2 = trim($form->direccionacudiente2);
      $register->barrioacudiente2 = trim($form->barrioacudiente2);
      $register->localidadacudiente2 = trim($form->localidadacudiente2);
      $register->celularacudiente2 = trim($form->celularacudiente2);
      $register->whatsappacudiente2 = trim($form->whatsappacudiente2);
      $register->correoacudiente2 = $this->lower($form->correoacudiente2);
      $register->formacionacudiente2 = trim($form->formacionacudiente2);
      $register->tituloacudiente2 = $this->upper($form->tituloacudiente2);
      $register->tipoocupacionacudiente2 = trim($form->tipoocupacionacudiente2);
      $register->empresaacudiente2 = $this->upper($form->empresaacudiente2);
      $register->direccionempresaacudiente2 = $this->upper($form->direccionempresaacudiente2);
      $register->ciudadempresaacudiente2 = trim($form->ciudadempresaacudiente2);
      $register->barrioempresaacudiente2 = trim($form->barrioempresaacudiente2);
      $register->localidadempresaacudiente2 = trim($form->localidadempresaacudiente2);
      $register->cargoempresaacudiente2 = $this->upper($form->cargoempresaacudiente2);
      $register->fechaingresoempresaacudiente2 = $form->fechaingresoempresaacudiente2;
      $register->rhacu2 = trim($form->rhacu2);
      $register->sexoacudiente2 = trim($form->sexoacudiente2);
      $register->nombreemergencia = $this->ucwords($form->nombreemergencia);
      $register->documentoemergencia = trim($form->documentoemergencia);
      $register->direccionemergencia = $this->upper($form->direccionemergencia);
      $register->barrioemergencia = trim($form->barrioemergencia);
      $register->localidademergencia = trim($form->localidademergencia);
      $register->celularemergencia = trim($form->celularemergencia);
      $register->whatsappemergencia = trim($form->whatsappemergencia);
      $register->parentescoemergencia = $this->fu($form->parentescoemergencia);
      $register->correoemergencia = $this->lower($form->correoemergencia);
      $register->nombreautorizado1 = $this->ucwords($form->nombreautorizado1);
      $register->documentoautorizado1 = trim($form->documentoautorizado1);
      $register->parentescoautorizado1 = trim($form->parentescoautorizado1);
      $register->nombreautorizado2 = $this->ucwords($form->nombreautorizado2);
      $register->documentoautorizado2 = trim($form->documentoautorizado2);
      $register->parentescoautorizado2 = trim($form->parentescoautorizado2);
      $register->fechaingreso = $form->fechaingreso;
      $register->expectatives_likechild = $this->fu($form->expectatives_likechild);
      $register->expectatives_activityschild = $this->fu($form->expectatives_activityschild);
      $register->expectatives_toychild = $this->fu($form->expectatives_toychild);
      $register->expectatives_aspectchild = $this->fu($form->expectatives_aspectchild);
      $register->expectatives_dreamforchild = $this->fu($form->expectatives_dreamforchild);
      $register->expectatives_learnchild = $this->fu($form->expectatives_learnchild);
      $register->cultural_eventfamily = $this->fu($form->cultural_eventfamily);
      $register->cultural_supportculturefamily = $this->fu($form->cultural_supportculturefamily);
      $register->cultural_gardenlearnculture = $this->fu($form->cultural_gardenlearnculture);
      $register->cultural_shareculturefamily = $this->fu($form->cultural_shareculturefamily);
      $register->status = $form->status;
      $register->migracion = 1;
      $register->periodo_escolar = trim($form->periodo_escolar);
      $register->save();


      $form->migracion = 1;
      $form->save();
      // dd($msjMigration);
      return redirect()->route('filesAdmission')->with('SuccessForm', 'MIGRACION PROCESADA: (' . $msjMigration . ')');

      // $validateStudent = Student::where('numberdocument',$form->numerodocumento)->first();
      // if($validateStudent == null){
      //     $threename = $form->apellidos;
      //     $fourname = null;
      //     $findSpace = strpos($form->apellidos,' ');
      //     if($findSpace !== false){
      //         $separatedLastname = explode(' ',$form->apellidos);
      //         $threename = $separatedLastname[0];
      //         $fourname = $separatedLastname[1];
      //     }
      //     $yearsold = $this->getYearsold($form->fechanacimiento);
      //     $district = District::find($form->barrioacudiente1);
      //     if($form->asistenciaterapias == 'Si'){
      //         $healthDescription = $this->upper('(' . $form->cual . ') Enfermedades actuales: (' . $form->enfermedades . '), Tratamientos m??dicos: (' . $form->tratamientos . '), Alergias: (' . $form->alergias . '), Asistencia a terapias: (Si, ' . $form->cual . ')');
      //     }else{
      //         $healthDescription = $this->upper('(' . $form->cual . ') Enfermedades actuales: (' . $form->enfermedades . '), Tratamientos m??dicos: (' . $form->tratamientos . '), Alergias: (' . $form->alergias . '), Asistencia a terapias: (No)');
      //     }
      //     $photoName = 'studentdefault.png';
      //     if($form->foto != 'photodefault.png'){
      //         Storage::disk('kindersoft')->move('admisiones/fotosaspirantes/'.$form->foto,'students'.$form->foto);
      //         $photoName = $form->foto;
      //         $form->foto = 'photodefault.png';
      //     }
      //     $validateTypedocument = Document::where('type',$this->upper($form->tipodocumento))->first();
      //     if($validateTypedocument != null){
      //         $typedocumentId = $validateTypedocument->id;
      //     }else{
      //         $newtype = Document::create([
      //             'type' => $this->upper($form->tipodocumento),
      //         ]);
      //         $typedocumentId = $newtype->id;
      //     }
      //     Student::create([
      //         'typedocument_id' => $typedocumentId,
      //         'numberdocument' => $form->numerodocumento,
      //         'photo' => $photoName,
      //         'firstname' => $this->upper($form->nombres),
      //         'threename' => $this->upper($threename),
      //         'fourname' => $this->upper($fourname),
      //         'birthdate' => $form->fechanacimiento,
      //         'yearsold' => $yearsold,
      //         'address' => $this->upper($form->direccionacudiente1),
      //         'cityhome_id' => $district->location->city->id,
      //         'locationhome_id' => $district->location->id,
      //         'dictricthome_id' => $district->id,
      //         'bloodtype_id' => $form->tiposangre,
      //         'gender' => $this->upper($form->genero),
      //         'health_id' => $form->health,
      //         'additionalHealt' => 'SI',
      //         'additionalHealtDescription' => $healthDescription
      //     ]);
      //     $validateTypedocumentattendant = Document::where('type','NO REPORTA')->first();
      //     if($validateTypedocumentattendant != null){
      //         $typedocumentAttendant = $validateTypedocumentattendant->id;
      //     }else{
      //         $newtypenon = Document::create([
      //             'type' => $this->upper('NO REPORTA'),
      //         ]);
      //         $typedocumentAttendant = $newtypenon->id;
      //     }
      //     $validateAttendant1 = Attendant::where('numberdocument',$form->documentoacudiente1)->first();
      //     if($validateAttendant1 == null){
      //         $firstnameAttendant1 = $this->getFirstname($form->nombreacudiente1);
      //         $threenameAttendant1 = $this->getLastname($form->nombreacudiente1);
      //         $antiquity = $this->getYearsold($form->fechaingresoempresaacudiente1);
      //         $separatedAntiquity = explode('-', $antiquity);
      //         $district1 = District::find($form->barrioacudiente1);
      //         $districtcompany1 = District::find($form->barrioempresaacudiente1);
      //         Attendant::create([
      //             'typedocument_id' => $typedocumentAttendant,
      //             'numberdocument' => $form->documentoacudiente1,
      //             'firstname' => $this->upper($firstnameAttendant1),
      //             'threename' => $this->upper($threenameAttendant1),
      //             'address' => $this->upper($form->direccionacudiente1),
      //             'cityhome_id' => $district1->location->city->id,
      //             'locationhome_id' => $district1->location->id,
      //             'dictricthome_id' => $district1->id,
      //             'phoneone' => $form->celularacudiente1,
      //             'phonetwo' => null,
      //             'whatsapp' => $form->whatsappacudiente1,
      //             'emailone' => $this->lower($form->correoacudiente1),
      //             'emailtwo' => null,
      //             'bloodtype_id' => null,
      //             'gender' => 'INDEFINIDO',
      //             'profession_id' => null,
      //             'company' => $this->upper($form->empresaacudiente1),
      //             'position' => $this->upper($form->cargoempresaacudiente1),
      //             'antiquity' => $separatedAntiquity[0],
      //             'addresscompany' => $this->upper($form->direccionempresaacudiente1),
      //             'citycompany_id' => $districtcompany1->location->city->id,
      //             'locationcompany_id' => $districtcompany1->location->id,
      //             'dictrictcompany_id' => $districtcompany1->id
      //         ]);
      //     }
      //     $validateAttendant2 = Attendant::where('numberdocument',$form->documentoacudiente2)->first();
      //     if($validateAttendant2 == null){
      //         $firstnameAttendant2 = $this->getFirstname($form->nombreacudiente2);
      //         $threenameAttendant2 = $this->getLastname($form->nombreacudiente2);
      //         $antiquity = $this->getYearsold($form->fechaingresoempresaacudiente2);
      //         $separatedAntiquity = explode('-', $antiquity);
      //         $district2 = District::find($form->barrioacudiente2);
      //         $districtcompany2 = District::find($form->barrioempresaacudiente2);
      //         Attendant::create([
      //             'typedocument_id' => $typedocumentAttendant,
      //             'numberdocument' => $form->documentoacudiente2,
      //             'firstname' => $this->upper($firstnameAttendant2),
      //             'threename' => $this->upper($threenameAttendant2),
      //             'address' => $this->upper($form->direccionacudiente2),
      //             'cityhome_id' => $district2->location->city->id,
      //             'locationhome_id' => $district2->location->id,
      //             'dictricthome_id' => $district2->id,
      //             'phoneone' => $form->celularacudiente2,
      //             'phonetwo' => null,
      //             'whatsapp' => $form->whatsappacudiente2,
      //             'emailone' => $this->lower($form->correoacudiente2),
      //             'emailtwo' => null,
      //             'bloodtype_id' => null,
      //             'gender' => 'INDEFINIDO',
      //             'profession_id' => null,
      //             'company' => $this->upper($form->empresaacudiente2),
      //             'position' => $this->upper($form->cargoempresaacudiente2),
      //             'antiquity' => $separatedAntiquity[0],
      //             'addresscompany' => $this->upper($form->direccionempresaacudiente2),
      //             'citycompany_id' => $districtcompany2->location->city->id,
      //             'locationcompany_id' => $districtcompany2->location->id,
      //             'dictrictcompany_id' => $districtcompany2->id
      //         ]);
      //     }
      //     $form->migracion = 1;
      //     $namesChild = $form->nombres . ' ' . $form->apellidos;
      //     $form->save();
      //     return redirect()->route('filesAdmission')->with('SuccessForm', 'Datos de formulario de ni??o/ni??a (' . $namesChild . ') MIGRADOS hacia (ALUMNOS) y (ACUDIENTES) CORRECTAMENTE');
      // }else{
      //     return redirect()->route('filesAdmission')->with('SecondaryForm', 'Ya existe un registro de alumno con el n??mero de identificaci??n ' . $form->numerodocumento);
      // }
    } else {
      return redirect()->route('filesAdmission')->with('SecondaryForm', 'No se encuentran el formulario a migrar');
    }
  }

  function bisiesto($ano_actual)
  {
    $bisiesto = false;
    //probamos si el mes de febrero del a??o actual tiene 29 d??as
    if (checkdate(2, 29, $ano_actual)) {
      $bisiesto = true;
    }
    return $bisiesto;
  }

  function getYearsold($nacimiento)
  {
    // separamos en partes las fechas
    $array_nacimiento = explode("-", $nacimiento);
    $array_actual = explode("-", Date('Y-m-d'));
    $anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos a??os
    $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
    $dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos d??as
    //ajuste de posible negativo en $d??as
    if ($dias < 0) {
      --$meses;
      //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
      switch ($array_actual[1]) {
        case 1:
          $dias_mes_anterior = 31;
          break;
        case 2:
          $dias_mes_anterior = 31;
          break;
        case 3:
          if ($this->bisiesto($array_actual[0])) {
            $dias_mes_anterior = 29;
            break;
          } else {
            $dias_mes_anterior = 28;
            break;
          }
        case 4:
          $dias_mes_anterior = 31;
          break;
        case 5:
          $dias_mes_anterior = 30;
          break;
        case 6:
          $dias_mes_anterior = 31;
          break;
        case 7:
          $dias_mes_anterior = 30;
          break;
        case 8:
          $dias_mes_anterior = 31;
          break;
        case 9:
          $dias_mes_anterior = 31;
          break;
        case 10:
          $dias_mes_anterior = 30;
          break;
        case 11:
          $dias_mes_anterior = 31;
          break;
        case 12:
          $dias_mes_anterior = 30;
          break;
      }

      $dias = $dias + $dias_mes_anterior;
    }

    //ajuste de posible negativo en $meses
    if ($meses < 0) {
      --$anos;
      $meses = $meses + 12;
    }
    return $anos . '-' . $meses;
  }


  /* ===========================================================================================================
            FUNCIONES PARA CONVERTIR CADENAS DE TEXTO (Mayusculas/Minusculas/Solo primera en Mayuscula)
    =========================================================================================================== */

  function upper($string)
  {
    return mb_strtoupper(trim($string), 'UTF-8');
  }

  function lower($string)
  {
    return mb_strtolower(trim($string), 'UTF-8');
  }

  function fu($string)
  {
    return ucfirst(mb_strtolower(trim($string), 'UTF-8'));
  }

  function ucwords($string)
  {
    return ucwords(mb_strtolower(trim($string), 'UTF-8'));
  }
}
