<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\City;

use App\Models\User;
use App\Models\Garden;
use App\Models\General;
use App\Models\Numeration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generalTo()
    {
        $general = General::first();
        $numeration = DB::table('numbersinitial')->first();
        // $numeration = Numeration::first();
        return view('modules.facturations.general', compact('general', 'numeration'));
    }

    public function generalSave(Request $request)
    {
        /*
        $request->fgId
        $request->fgRegime
        $request->fgTaxpayer
        $request->fgAutoretainer
        $request->fgActivityOne
        $request->fgActivityTwo
        $request->fgActivityThree
        $request->fgActivityFour
        $request->fgResolution
        $request->fgDateresolution
        $request->fgMountactive
        $request->fgDatefallresolution
        $request->fgPrefix
        $request->fgNumerationsince
        $request->fgNumerationuntil
        $request->fgBank
        $request->fgAccounttype
        $request->fgNumberaccount
        $request->fgNotes
        */
        // dd($request->all());
        try {
            if (isset($request->fgId) && $request->fgId != '') {
                $general = General::find(trim($request->fgId));
                if ($general != null) {
                    $general->fgTaxpayer = trim($request->fgTaxpayer);
                    $general->fgAutoretainer = trim($request->fgAutoretainer);
                    $general->fgActivityOne = trim($request->fgActivityOne);
                    if (trim($request->fgActivityTwo) != null) {
                        $general->fgActivityTwo = trim($request->fgActivityTwo);
                    } else {
                        $general->fgActivityTwo = null;
                    }
                    if (trim($request->fgActivityThree) != null) {
                        $general->fgActivityThree = trim($request->fgActivityThree);
                    } else {
                        $general->fgActivityThree = null;
                    }
                    if (trim($request->fgActivityFour) != null) {
                        $general->fgActivityFour = trim($request->fgActivityFour);
                    } else {
                        $general->fgActivityFour = null;
                    }
                    $general->fgRegime = mb_strtoupper($request->fgRegime);
                    $general->fgResolution = trim($request->fgResolution);
                    $general->fgDateresolution = trim($request->fgDateresolution);
                    $general->fgMountactive = trim($request->fgMountactive);
                    $general->fgDatefallresolution = trim($request->fgDatefallresolution);
                    $general->fgPrefix = mb_strtoupper(trim($request->fgPrefix));
                    $general->fgNumerationsince = trim($request->fgNumerationsince);
                    $general->fgNumerationuntil = trim($request->fgNumerationuntil);
                    $general->fgBank = mb_strtoupper(trim($request->fgBank));
                    $general->fgAccounttype = trim($request->fgAccounttype);
                    $general->fgNumberaccount = trim($request->fgNumberaccount);
                    $general->fgNotes = mb_strtoupper(trim($request->fgNotes));
                    $general->save();
                    return redirect()->route('general')->with('PrimaryUpdateGeneral', 'INFORMACION GENERAL ACTUALIZADA CORRECTAMENTE');
                } else {
                    return redirect()->route('general')->with('SecondaryUpdateGeneral', 'NO FUE POSIBLE ACTUALIZAR INFORMACION GENERAL YA QUE NO SE ENCUENTRA EL REGISTRO EN LA BASE DE DATOS');
                }
            } else {
                $oneActivity = (trim($request->fgActivityOne) == '') ? null : trim($request->fgActivityOne);
                $twoActivity = (trim($request->fgActivityTwo) == '') ? null : trim($request->fgActivityTwo);
                $threeActivity = (trim($request->fgActivityThree) == '') ? null : trim($request->fgActivityThree);
                $fourActivity = (trim($request->fgActivityFour) == '') ? null : trim($request->fgActivityFour);
                General::create([
                    'fgRegime' => trim($request->fgRegime),
                    'fgTaxpayer' => trim($request->fgTaxpayer),
                    'fgAutoretainer' => trim($request->fgAutoretainer),
                    'fgActivityOne' => $oneActivity,
                    'fgActivityTwo' => $twoActivity,
                    'fgActivityThree' => $threeActivity,
                    'fgActivityFour' => $fourActivity,
                    'fgResolution' => trim($request->fgResolution),
                    'fgDateresolution' => trim($request->fgDateresolution),
                    'fgMountactive' => trim($request->fgMountactive),
                    'fgDatefallresolution' => trim($request->fgDatefallresolution),
                    'fgPrefix' => mb_strtoupper(trim($request->fgPrefix)),
                    'fgNumerationsince' => trim($request->fgNumerationsince),
                    'fgNumerationuntil' => trim($request->fgNumerationuntil),
                    'fgBank' => mb_strtoupper(trim($request->fgBank)),
                    'fgAccounttype' => trim($request->fgAccounttype),
                    'fgNumberaccount' => trim($request->fgNumberaccount),
                    'fgNotes' => mb_strtoupper(trim($request->fgNotes))
                ]);
                return redirect()->route('general')->with('SuccessSaveGeneral', 'INFORMACION GENERAL GUARDADA CORRECTAMENTE');
            }
        } catch (Exception $ex) {
            // Exception code
        }
    }

    public function generalNumbersSave(Request $request)
    {
        /*
        $request->fgNumberinitialFacture
        $request->fgNumberinitialVoucherentry
        $request->fgNumberinitialVoucheregress
        */
        try {
            if (isset($request->niId) && $request->niId != '') {
                $numeration = Numeration::find(trim($request->niId));
                if ($numeration != null) {
                    $numeration->niFacture = trim($request->fgNumberinitialFacture);
                    $numeration->niVoucherentry = trim($request->fgNumberinitialVoucherentry);
                    $numeration->niVoucheregress = trim($request->fgNumberinitialVoucheregress);
                    $numeration->save();
                    return redirect()->route('general')->with('PrimaryUpdateGeneral', 'NUMERACION INICIAL ACTUALIZADA CORRECTAMENTE');
                } else {
                    return redirect()->route('general')->with('SecondaryUpdateGeneral', 'NO FUE POSIBLE ACTUALIZAR LA NUMERACION INICIAL YA QUE NO SE ENCUENTRA EL REGISTRO EN LA BASE DE DATOS');
                }
            } else {
                Numeration::create([
                    'niFacture' => trim($request->fgNumberinitialFacture),
                    'niVoucherentry' => trim($request->fgNumberinitialVoucherentry),
                    'niVoucheregress' => trim($request->fgNumberinitialVoucheregress)
                ]);
                return redirect()->route('general')->with('SuccessSaveGeneral', 'NUMERACION INICIAL GUARDADA CORRECTAMENTE');
            }
        } catch (Exception $ex) {
            // Exception code
        }
    }

    public function infoCompany()
    {
        $user = User::find(auth()->id());
        $garden = Garden::select('garden.*', 'citys.name as nameCity', 'locations.name as nameLocation', 'districts.name as nameDistrict')
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();
        $citys = City::all();

        return view('modules.garden.companyInformation',compact('user','garden','citys'));
    }

    public function logosCompany()
    {
        return view('modules.garden.companyLogo');
    }
}
