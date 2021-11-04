<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Garden;

class GardenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newGarden(Request $request){
        //dd($request->garLogo);
        try{
            $firmwitness = null;
            if($request->hasFile('garFirmwitness')){
                $firmfile = $request->file('garFirmwitness');
                $extension = $firmfile->extension();
                if($validate->garFirmwitness != null){
                    Storage::disk('kindersoft')->delete('garden/firm/'.$validate->garFirmwitness);
                }
                Storage::disk('kindersoft')->putFileAs('garden/firm',$firmfile,'firmwitness.'.$extension);
                $firmwitness = 'firmwitness.'.$extension;
            }
            if($request->hasFile('garLogo')){
                if($request->hasFile('garCode')){
                    if($request->hasFile('garFirm')){
                        $logo = $request->file('garLogo');
                        $code = $request->file('garCode');
                        $firm = $request->file('garFirm');
                        $namelogo = $logo->getClientOriginalName();
                        $namecode = $code->getClientOriginalName();
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamelogo = explode('.', $namelogo);
                        $separatednamecode = explode('.', $namecode);
                        $separatednamefirm = explode('.', $namefirm);
                        $namelogowithextention = 'logo.' . $this::lower($separatednamelogo[1]);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garNamelogo' => $namelogowithextention,
                            'garCode' => $namecodewithextention,
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garFirm' => $namefirmwithextention,
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }else{
                        $logo = $request->file('garLogo');
                        $code = $request->file('garCode');
                        $namelogo = $logo->getClientOriginalName();
                        $namecode = $code->getClientOriginalName();
                        $separatednamelogo = explode('.', $namelogo);
                        $separatednamecode = explode('.', $namecode);
                        $namelogowithextention = 'logo.' . $this::lower($separatednamelogo[1]);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garNamelogo' => $namelogowithextention,
                            'garCode' => $namecodewithextention,
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }
                }else{
                    if($request->hasFile('garFirm')){
                        $logo = $request->file('garLogo');
                        $firm = $request->file('garFirm');
                        $namelogo = $logo->getClientOriginalName();
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamelogo = explode('.', $namelogo);
                        $separatednamefirm = explode('.', $namefirm);
                        $namelogowithextention = 'logo.' . $this::lower($separatednamelogo[1]);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garNamelogo' => $namelogowithextention,
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garFirm' => $namefirmwithextention,
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }else{
                        $logo = $request->file('garLogo');
                        $namelogo = $logo->getClientOriginalName();
                        $separatedname = explode('.', $namelogo);
                        $namelogowithextention = 'logo.' . $this::lower($separatedname[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garNamelogo' => $namelogowithextention,
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }
                }
            }else{
                if($request->hasFile('garCode')){
                    if($request->hasFile('garFirm')){
                        $code = $request->file('garCode');
                        $firm = $request->file('garFirm');
                        $namecode = $code->getClientOriginalName();
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamecode = explode('.', $namecode);
                        $separatednamefirm = explode('.', $namefirm);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garCode' => $namecodewithextention,
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garFirm' => $namefirmwithextention,
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }else{
                        $code = $request->file('garCode');
                        $namecode = $code->getClientOriginalName();
                        $separatednamecode = explode('.', $namecode);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garCode' => $namecodewithextention,
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }   
                }else{
                    if($request->hasFile('garFirm')){
                        $firm = $request->file('garFirm');
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamefirm = explode('.', $namefirm);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garFirm' => $namefirmwithextention,
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }else{
                        Garden::create([
                            'garReasonsocial' => trim($request->garReasonsocial),
                            'garNamecomercial' => trim($request->garNamecomercial),
                            'garNit' => trim($request->garNit) . '-' . trim($request->garVerification),
                            'garCity_id' => trim($request->garCity),
                            'garLocation_id' => trim($request->garLocation),
                            'garDistrict_id' => trim($request->garDistrict),
                            'garAddress' => trim($request->garAddress),
                            'garPhone' => trim($request->garPhone),
                            'garPhoneone' => trim($request->garPhoneone),
                            'garPhonetwo' => trim($request->garPhonetwo),
                            'garPhonethree' => trim($request->garPhonethree),
                            'garWhatsapp' => trim($request->garWhatsapp),
                            'garWebsite' => trim($request->garWebsite),
                            'garMailone' => trim($request->garMailone),
                            'garMailtwo' => trim($request->garMailtwo),
                            'garNamerepresentative' => trim($request->garNamerepresentative),
                            'garCardrepresentative' => trim($request->garCardrepresentative),
                            'garNamewitness' => trim($request->garNamewitness),
                            'garCardwitness' => trim($request->garCardwitness),
                            'garFirmwitness' => $firmwitness
                        ]);
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN DEFINIDO CORRECTAMENTE LOS DATOS DEL JARDIN');
                    }
                }
            }
        }catch(Exception $ex){
                return redirect()->route('profile')->with('SecondarySaveGarden', 'No es posible guardar ahora los datos del jardin, Comuniquese con el administrador del sistema');
        }
    }

    public function updateGarden(Request $request){
        //dd($request->all());
        try{
            // VALIDACION DE IMAGEN DE ATRAS
            $firmwitness = 'sin_cambio';
            if($request->hasFile('garFirmwitness_update')){
                $firmfile = $request->file('garFirmwitness_update');
                $extension = $firmfile->extension();
                Storage::disk('kindersoft')->putFileAs('garden/firm/',$firmfile,'firmwitness.' . $extension);
                $firmwitness = 'firmwitness.' . $extension;
            }
            if($request->hasFile('garLogo_update')){
                if($request->hasFile('garCode_update')){
                    if($request->hasFile('garFirm_update')){
                        $logo = $request->file('garLogo_update');
                        $code = $request->file('garCode_update');
                        $firm = $request->file('garFirm_update');
                        $namelogo = $logo->getClientOriginalName();
                        $namecode = $code->getClientOriginalName();
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamelogo = explode('.', $namelogo);
                        $separatednamecode = explode('.', $namecode);
                        $separatednamefirm = explode('.', $namefirm);
                        $namelogowithextention = 'logo.' . $this::lower($separatednamelogo[1]);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garNamelogo = $namelogowithextention;
                        $garden->garCode = $namecodewithextention;
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garFirm = $namefirmwithextention;
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }else{
                        $logo = $request->file('garLogo_update');
                        $code = $request->file('garCode_update');
                        $namelogo = $logo->getClientOriginalName();
                        $namecode = $code->getClientOriginalName();
                        $separatednamelogo = explode('.', $namelogo);
                        $separatednamecode = explode('.', $namecode);
                        $namelogowithextention = 'logo.' . $this::lower($separatednamelogo[1]);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garNamelogo = $namelogowithextention;
                        $garden->garCode = $namecodewithextention;
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }
                }else{
                    if($request->hasFile('garFirm_update')){
                        $logo = $request->file('garLogo_update');
                        $firm = $request->file('garFirm_update');
                        $namelogo = $logo->getClientOriginalName();
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamelogo = explode('.', $namelogo);
                        $separatednamefirm = explode('.', $namefirm);
                        $namelogowithextention = 'logo.' . $this::lower($separatednamelogo[1]);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garNamelogo = $namelogowithextention;
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garFirm = $namefirmwithextention;
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }else{
                        $logo = $request->file('garLogo_update');
                        $namelogo = $logo->getClientOriginalName();
                        $separatedname = explode('.', $namelogo);
                        $namelogowithextention = 'logo.' . $this::lower($separatedname[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$logo,$namelogowithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garNamelogo = $namelogowithextention;
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }
                }
            }else{
                if($request->hasFile('garCode_update')){
                    if($request->hasFile('garFirm_update')){
                        $code = $request->file('garCode_update');
                        $firm = $request->file('garFirm_update');
                        $namecode = $code->getClientOriginalName();
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamecode = explode('.', $namecode);
                        $separatednamefirm = explode('.', $namefirm);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garCode = $namecodewithextention;
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garFirm = $namefirmwithextention;
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }else{
                        $code = $request->file('garCode_update');
                        $namecode = $code->getClientOriginalName();
                        $separatednamecode = explode('.', $namecode);
                        $namecodewithextention = 'code.' . $this::lower($separatednamecode[1]);
                        Storage::disk('kindersoft')->putFileAs('garden',$code,$namecodewithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garCode = $namecodewithextention;
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }
                }else{
                    if($request->hasFile('garFirm_update')){
                        $firm = $request->file('garFirm_update');
                        $namefirm = $firm->getClientOriginalName();
                        $separatednamefirm = explode('.', $namefirm);
                        $namefirmwithextention = 'firm.' . $this::lower($separatednamefirm[1]);
                        Storage::disk('kindersoft')->putFileAs('garden/firm',$firm,$namefirmwithextention);
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garFirm = $namefirmwithextention;
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }else{
                        $garden = Garden::find(trim($request->garId_update));
                        $garden->garReasonsocial = trim($request->garReasonsocial_update);
                        $garden->garNamecomercial = trim($request->garNamecomercial_update);
                        $garden->garNit = trim($request->garNit_update) . '-' . trim($request->garVerification_update);
                        $garden->garCity_id = trim($request->garCity_update);
                        $garden->garLocation_id = trim($request->garLocation_update);
                        $garden->garDistrict_id = trim($request->garDistrict_update);
                        $garden->garAddress = trim($request->garAddress_update);
                        $garden->garPhone = trim($request->garPhone_update);
                        $garden->garPhoneone = trim($request->garPhoneone_update);
                        $garden->garPhonetwo = trim($request->garPhonetwo_update);
                        $garden->garPhonethree = trim($request->garPhonethree_update);
                        $garden->garWhatsapp = trim($request->garWhatsapp_update);
                        $garden->garWebsite = trim($request->garWebsite_update);
                        $garden->garMailone = trim($request->garMailone_update);
                        $garden->garMailtwo = trim($request->garMailtwo_update);
                        $garden->garNamerepresentative = trim($request->garNamerepresentative_update);
                        $garden->garCardrepresentative = trim($request->garCardrepresentative_update);
                        $garden->garNamewitness = trim($request->garNamewitness_update);
                        $garden->garCardwitness = trim($request->garCardwitness_update);
                        if($firmwitness != 'sin_cambio'){
                            $garden->garFirmwitness = $firmwitness;
                        }
                        $garden->save();
                        return redirect()->route('profile')->with('SuccessSaveGarden', 'SE HAN ACTUALIZADO CORRECTAMENTE LOS DATOS');
                    }
                }
            }
        }catch(Exception $ex){

        }
    }
}
