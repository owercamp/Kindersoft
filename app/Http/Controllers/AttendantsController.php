<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewAttendantRequest;

use App\Models\Attendant;
use App\Models\Document;
use App\Models\Bloodtype;
use App\Models\Profession;
use App\Models\City;
use App\Models\Location;
use App\Models\District;
use App\Models\Legalization;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AttendantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index()
    {
        $attendants = Attendant::all();
        return view('modules.attendants.index', compact('attendants'));
    }

    function editAttendant($id)
    {
        $attendant = Attendant::find($id);
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $professions = Profession::all();
        // $country = DB::table("paises_prefijoopcional")->limit(5)->get();
        $countrys = DB::table("paises_prefijoopcional")->pluck('nom_pais_prefijoopcional','iddep_pais_prefijoopcional');
        // dd($country);
        $citys = City::all();
        return view('modules.attendants.edit', compact('attendant', 'documents', 'bloodtypes', 'professions', 'countrys', 'citys'));
    }

    function updateAttendant(Request $request, $id)
    {
        try {
            $attendantUpdate = Attendant::where('typedocument_id', trim($request->typedocument_id_edit))
                ->where('numberdocument', trim($request->numberdocument_edit))
                ->where('id', '!=', $id)
                ->first();

            if ($attendantUpdate == null) {
                $attendant = Attendant::find($id);
                $attendant->typedocument_id = $request->typedocument_id_edit;
                $attendant->numberdocument = $request->numberdocument_edit;
                $attendant->firstname = mb_strtoupper(trim($request->firstname_edit));
                $attendant->threename = mb_strtoupper(trim($request->threename_edit));
                $attendant->address = mb_strtoupper(trim($request->address_edit));
                $attendant->cityhome_id = $request->cityhome_id_edit;
                $attendant->locationhome_id = $request->locationhome_id_edit;
                $attendant->dictricthome_id = $request->dictricthome_id_edit;
                $attendant->phoneone = $request->phoneone_edit;
                $attendant->phonetwo = $request->phonetwo_edit;
                $attendant->whatsapp = $request->whatsapp_edit;
                $attendant->emailone = mb_strtolower(trim($request->emailone_edit));
                $attendant->emailtwo = mb_strtolower(trim($request->emailtwo_edit));
                $attendant->bloodtype_id = $request->bloodtype_id_edit;
                $attendant->gender = mb_strtoupper(trim($request->gender_edit));
                $attendant->profession_id = $request->profession_id_edit;
                $attendant->company = mb_strtoupper(trim($request->company_edit));
                $attendant->position = mb_strtoupper(trim($request->position_edit));
                $attendant->antiquity = $request->antiquity_edit;
                $attendant->addresscompany = mb_strtoupper(trim($request->addresscompany_edit));
                $attendant->citycompany_id = $request->citycompany_id_edit;
                $attendant->locationcompany_id = $request->locationcompany_id_edit;
                $attendant->dictrictcompany_id = $request->dictrictcompany_id_edit;
                $attendant->save();
                return redirect()->route('attendants')->with('PrimaryUpdateAttendant', 'Acudiente con ID: ' . $request->numberdocument_edit . ', actualizado correctamente');
            } else {
                return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'Acudiente: ' . ucfirst(strtolower($request->numberdocument_edit)) . ', NO ACTUALIZADO, Ya existe un acudiente con el numero de identificación ingresado');
            }
        } catch (Exception $ex) {
            return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'No fue posible actualizar el acudiente ahora, comuniquese con el administrador');
        }
    }

    function deleteAttendant($id)
    {
        try {
            $attendant = Attendant::find($id);
            $names = $attendant->firstname . " con ID: " . $attendant->numberdocument;
            $attendant->delete();
            return redirect()->route('attendants')->with('WarningDeleteAttendant', 'Acudiente ' . $names . ', eliminado correctamente');
        } catch (Exception $ex) {
            return redirect()->route('attendants')->with('SecondaryDeleteAttendant', 'No fue posible eliminar el acudiente ahora, comuniquese con el administrador');
        }
    }

    function activeAttendant($id)
    {
        $active = Attendant::find($id);
        $validContractDay = Legalization::where('legAttendantmother_id', trim($id))
            ->orWhere('legAttendantfather_id', trim($id))
            ->whereDate('legDateFinal', '>=', Carbon::now()->format('Y-m-d'))
            ->first();
        if ($validContractDay == null) {
            $inactive = Attendant::find($id);
            if ($inactive != null) {
                $inactive->status = "INACTIVO";
                $inactive->save();
                return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'Estado del acudiente ' . $this->upper($inactive->firstname) . ' ' . $this->upper($inactive->threename) . ' fue actualizado a: INACTIVO');
            } else {
                return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'Error al actualizar el estado del acudiente');
            }
        } else {
            return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'El acudiente ' . $this->upper($active->firstname) . ' ' . $this->upper($active->threename) . ' cuenta con contratos relacionados');
        }
    }

    function inactiveAttendant($id)
    {
        $active = Attendant::find($id);
        $validContractDay = Legalization::where('legAttendantmother_id', trim($id))
            ->orWhere('legAttendantfather_id', trim($id))
            ->whereDate('legDateFinal', '>=', Carbon::now()->format('Y-m-d'))
            ->first();
        if ($validContractDay == null) {
            $inactive = Attendant::find($id);
            if ($inactive != null) {
                $inactive->status = "ACTIVO";
                $inactive->save();
                return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'Estado del acudiente ' . $this->upper($inactive->firstname) . ' ' . $this->upper($inactive->threename) . ' fue actualizado a: ACTIVO');
            } else {
                return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'Error al actualizar el estado del acudiente');
            }
        } else {
            return redirect()->route('attendants')->with('SecondaryUpdateAttendant', 'El acudiente ' . $this->upper($active->firstname) . ' ' . $this->upper($active->threename) . ' cuenta con contratos relacionados');
        }
    }

    function newAttendant()
    {
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $professions = Profession::all();
        $citys = City::all();
        return view('modules.attendants.new', compact('documents', 'bloodtypes', 'professions', 'citys'));
    }

    function saveAttendant(Request $request)
    {
        try {
            $attendantSave = Attendant::where('typedocument_id', trim($request->typedocument_id))
                ->where('numberdocument', trim($request->numberdocument))
                ->first();
            if ($attendantSave == null) {;
                Attendant::create([
                    'typedocument_id' => $request->typedocument_id,
                    'numberdocument' => $request->numberdocument,
                    'firstname' => mb_strtoupper(trim($request->firstname)),
                    'threename' => mb_strtoupper(trim($request->threename)),
                    'address' => mb_strtoupper(trim($request->address)),
                    'cityhome_id' => $request->cityhome_id,
                    'locationhome_id' => $request->locationhome_id,
                    'dictricthome_id' => $request->dictricthome_id,
                    'phoneone' => $request->phoneone,
                    'phonetwo' => $request->phonetwo,
                    'whatsapp' => $request->whatsapp,
                    'emailone' => mb_strtolower(trim($request->emailone)),
                    'emailtwo' => mb_strtolower(trim($request->emailtwo)),
                    'bloodtype_id' => $request->bloodtype_id,
                    'gender' => mb_strtoupper(trim($request->gender)),
                    'profession_id' => $request->profession_id,
                    'company' => mb_strtoupper(trim($request->company)),
                    'position' => mb_strtoupper(trim($request->position)),
                    'antiquity' => $request->antiquity,
                    'addresscompany' => mb_strtoupper(trim($request->addresscompany)),
                    'citycompany_id' => $request->citycompany_id,
                    'locationcompany_id' => $request->locationcompany_id,
                    'dictrictcompany_id' => $request->dictrictcompany_id
                ]);
                return redirect()->route('attendant.new')->with('SuccessSaveAttendant', 'Registro con ID: ' . $request->numberdocument . ', creado correctamente');
            } else {
                return redirect()->route('attendant.new')->with('SecondarySaveAttendant', 'Ya existe un registro con el número de identificacion ingresado');
            }
        } catch (Exception $ex) {
            return redirect()->route('attendant.new')->with('SecondarySaveAttendant', 'No es posible crear el registro ahora, comuniquese con el administrador');
        }
    }

    function detailsAttendant($id)
    {
        $attendant = Attendant::find($id);
        $documents = Document::all();
        $bloodtypes = Bloodtype::all();
        $professions = Profession::all();
        $citys = City::all();
        $locations = Location::all();
        $districts = District::all();
        return view('modules.attendants.details', compact('attendant', 'documents', 'bloodtypes', 'professions', 'citys', 'locations', 'districts'));
    }
}
