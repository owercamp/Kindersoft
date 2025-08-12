<?php

namespace App\Http\Controllers;

use App\Models\AcademicCircularFile;
use App\Models\AdministrativeCircularFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Garden;
use App\Models\Body;
use App\Models\Collaborator;
use App\Models\InternalMemo;
use App\Models\Numbercircular;
use App\Models\Numberciradmin;
use Exception;
use Illuminate\Support\Facades\App;

class CircularsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function bodycircularTo()
    {
        $bodys = Body::all();
        return view('modules.letters.bodycircular', compact('bodys'));
    }

    function saveBody(Request $request)
    {
        try {
            // dd($request->all());
            /*
                $request->bcName
                $request->bcDescription
            */
            $bodyValidate = Body::where('bcName', trim(mb_strtoupper($request->bcName)))->orWhere('bcDescription', trim(mb_strtoupper($request->bcDescription)))->first();
            if ($bodyValidate == null) {
                Body::create([
                    'bcName' => trim(mb_strtoupper($request->bcName)),
                    'bcDescription' => trim(mb_strtoupper($request->bcDescription, 'UTF-8'))
                ]);
                return redirect()->route('bodycircular')->with('SuccessSaveBody', 'CUERPO ' . trim(mb_strtoupper($request->bcName)) . ', GUARDADO');
            } else {
                return redirect()->route('bodycircular')->with('SecondarySaveBody', 'YA EXISTE UN CUERPO ' . trim(mb_strtoupper($request->bcName)) . ', CONSULTE LA TABLA');
            }
        } catch (Exception $ex) {
            return redirect()->route('bodycircular')->with('SecondarySaveBody', 'NO ES POSIBLE GUARDAR EL CUERPO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function updateBody(Request $request)
    {
        try {
            // dd($request->all());
            /*
                $request->bcIdEdit
                $request->bcNameEdit
                $request->bcDescriptionEdit
            */
            $bodyValidate = Body::where('bcId', '!=', $request->bcIdEdit)
                ->Where('bcName', trim(mb_strtoupper($request->bcNameEdit)))
                ->Where('bcDescription', trim(mb_strtoupper($request->bcDescriptionEdit, 'UTF-8')))
                ->first();
            if ($bodyValidate == null) {
                $bodyToEdit = Body::find(trim($request->bcIdEdit));
                $bodyToEdit->bcName = trim(mb_strtoupper($request->bcNameEdit));
                $bodyToEdit->bcDescription = trim(mb_strtoupper($request->bcDescriptionEdit, 'UTF-8'));
                $nameBody = trim(mb_strtoupper($request->bcNameEdit, 'UTF-8'));
                $bodyToEdit->save();
                return redirect()->route('bodycircular')->with('PrimaryUpdateBody', 'EVENTO ' . $nameBody . ', ACTUALIZADO');
            } else {
                return redirect()->route('bodycircular')->with('SecondaryUpdateBody', 'YA EXISTE UN CUERPO CON EL NOMBRE Y DESCRIPCION ESCRITA');
            }
        } catch (Exception $ex) {
            return redirect()->route('bodycircular')->with('SecondaryUpdateBody', 'NO ES POSIBLE ACTUALIZAR EL CUERPO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function deleteBody(Request $request)
    {
        try {
            // dd($request->all());
            $bodyToDelete = Body::find(trim($request->bcIdDelete));
            $nameBody = $bodyToDelete->bcName;
            $bodyToDelete->delete();
            return redirect()->route('bodycircular')->with('WarningDeleteBody', 'CUERPO ' . $nameBody . ', ELIMINADO');
        } catch (Exception $ex) {
            return redirect()->route('bodycircular')->with('SecondaryDeleteBody', 'NO ES POSIBLE ELIMINAR EL CUERPO, COMUNIQUESE CON EL ADMINISTRADOR');
        }
    }

    function circularacademicTo()
    {
        $bodys = Body::all();
        $collaborators = Collaborator::all();

        $numbernext = '00001';
        $validateMax =  Numbercircular::select('ncCode')->max('ncCode');
        if ($validateMax != null) {
            $numbernext =  $this->getCompletesNumber($validateMax + 1);
        }
        return view('modules.letters.circularAcademic', compact('bodys', 'collaborators', 'numbernext'));
    }

    //FUNCION PARA RETORNAR SIGUIENTE NUMERO DE CIRCULAR CON LOS CEROS
    function getCompletesNumber($number)
    {
        $len = strlen($number);
        switch ($len) {
            case 1:
                return '0000' . $number;
            case 2:
                return '000' . $number;
            case 3:
                return '00' . $number;
            case 4:
                return '0' . $number;
            case 5:
                return $number;
            default:
                return $number;
        }
    }

    public function circularacademicToList()
    {
        $collaborators = Collaborator::all();
        $lists = AcademicCircularFile::select('collaborators.*', 'academic_circular_files.*')
            ->join('collaborators', 'collaborators.id', 'academic_circular_files.acf_cirFrom')->get();
        return view('modules.letters.circularAcademicList', compact('lists', 'collaborators'));
    }

    public function circularacademicToView(Request $request)
    {
        $circular = AcademicCircularFile::Where('acf_id', $request->circular_id)->first();

        if (!$circular) {
            return back()->with('ErrorCircular', 'Circular no Encontrada');
        }
        $garden = Garden::select(
            'garden.*',
            'citys.name AS garNameCity',
            'locations.name AS garNameLocation',
            'districts.name AS garNameDistrict'
        )
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();

        $code = $circular->acf_cirNumber;
        $date = $circular->acf_cirDate;
        $to = $circular->acf_cirTo;
        $message = $circular->acf_cirBody;
        $from = Collaborator::where('id', $circular->acf_cirFrom)->first();
        $MyPDF = 'CIRCULAR_ACADEMICA_PARA_' . $circular->acf_cirTo . '.pdf';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('modules.letters.circularAcademicPdf', compact(
            'code',
            'date',
            'to',
            'message',
            'from',
            'garden'
        ));
        return $pdf->stream();
    }

    public function circularacademicToDelete(Request $request)
    {
        $circular = AcademicCircularFile::where('acf_id', $request->circularDelete)->first();
        $circularNumber = $circular->acf_cirNumber;
        if (!$circular) {
            return back()->with('ErrorCircular', 'Circular no Encontrada');
        }
        $circular->delete();
        DB::statement('alter table academic_circular_files auto_increment=1');
        return redirect()->route('circularacademic.list')->with('DeleteCircular', 'Circular N° ' . $circularNumber . ' ha sido eliminada');
    }

    function pdfCircularacademic(Request $request)
    {
        // dd($request->all());
        $code =  trim($request->cirNumber);
        $date =  trim($request->cirDate);
        $to =  trim(mb_strtoupper($request->cirTo, 'UTF-8'));
        $body_id =  trim($request->cirBody_id, 'UTF-8');
        $message =  trim(mb_strtoupper($request->cirBody, 'UTF-8'));
        $from = Collaborator::find(trim($request->cirFrom));
        $garden = Garden::select(
            'garden.*',
            'citys.name AS garNameCity',
            'locations.name AS garNameLocation',
            'districts.name AS garNameDistrict'
        )
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();
        $number = Numbercircular::where('ncCode', $code)->first();
        if ($number == null) {
            Numbercircular::create([
                "ncCode" => $code,
                "ncDate" => $date,
                "ncTo" => $to,
                "ncMessage" => $message,
                "ncFrom_id" => $from->id
            ]);
            $namefile = 'CIRCULAR_ACADEMICA_PARA_' . $request->cirTo . '.pdf';
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView(
                'modules.letters.circularAcademicPdf',
                compact(
                    'code',
                    'date',
                    'to',
                    'message',
                    'from',
                    'garden'
                )
            );
            //$pdf->setPaper("A6", "portrait");
            //$pdf->setPaper("A6", "landscape"); // PARA ORIENTACION HORIZONTAL DE PDF

            $format = new AcademicCircularFile();
            $format->acf_cirDate = $request->cirDate;
            $format->acf_cirNumber = $request->cirNumber;
            $format->acf_cirTo = $request->cirTo;
            $format->acf_cirBody_id = $request->cirBody_id;
            $format->acf_cirBody = $request->cirBody;
            $format->acf_cirFrom = $request->cirFrom;
            $format->save();

            return $pdf->download($namefile);
        } else {
            return redirect()->route('circularacademic')->with('SecondaryCircularacademic', 'Ya existe una circular académica con el N° ' . $code . ', Se ha actualizado, intentelo nuevamente');
        }
    }

    function circularadministrativeTo()
    {
        $bodys = Body::all();
        $collaborators = Collaborator::all();

        $numbernext = '00001';
        $validateMax =  Numberciradmin::select('ncaCode')->max('ncaCode');
        if ($validateMax != null) {
            $numbernext =  $this->getCompletesNumber($validateMax + 1);
        }
        return view('modules.letters.circularAdministrative', compact('bodys', 'collaborators', 'numbernext'));
    }

    function pdfCircularadministrative(Request $request)
    {
        // dd($request->all());
        $code =  trim($request->cirNumber);
        $date =  trim($request->cirDate);
        $to =  trim(mb_strtoupper($request->cirTo, 'UTF-8'));
        $body_id =  trim($request->cirBody_id, 'UTF-8');
        $message =  trim(mb_strtoupper($request->cirBody, 'UTF-8'));
        $from = Collaborator::find(trim($request->cirFrom));
        $garden = Garden::select(
            'garden.*',
            'citys.name AS garNameCity',
            'locations.name AS garNameLocation',
            'districts.name AS garNameDistrict'
        )
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();
        $number = Numberciradmin::where('ncaCode', $code)->first();
        if ($number == null) {
            Numberciradmin::create([
                "ncaCode" => $code,
                "ncaDate" => $date,
                "ncaTo" => $to,
                "ncaMessage" => $message,
                "ncaFrom_id" => $from->id
            ]);
            $namefile = 'CIRCULAR_ADMINISTRATIVA_PARA_' . trim(mb_strtoupper($request->cirTo, 'UTF-8')) . '.pdf';
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView(
                'modules.letters.circularAdministrativePdf',
                compact(
                    'code',
                    'date',
                    'to',
                    'message',
                    'from',
                    'garden'
                )
            );
            //$pdf->setPaper("A6", "portrait");
            //$pdf->setPaper("A6", "landscape"); // PARA ORIENTACION HORIZONTAL DE PDF

            $format = new AdministrativeCircularFile();
            $format->acf_cirDate = $request->cirDate;
            $format->acf_cirNumber = $request->cirNumber;
            $format->acf_cirTo = $request->cirTo;
            $format->acf_cirBody_id = $request->cirBody_id;
            $format->acf_cirBody = $request->cirBody;
            $format->acf_cirFrom = $request->cirFrom;
            $format->save();

            return $pdf->download($namefile);
        } else {
            return redirect()->route('circularadministrative')->with('SecondaryCircularadmin', 'Ya existe una circular administrativa con el N° ' . $code . ', Se ha actualizado, intentelo nuevamente');
        }
    }

    function circularadministrativeToList()
    {
        $collaborators = Collaborator::all();
        $lists = AdministrativeCircularFile::select('administrative_circular_file.*', 'collaborators.*')
            ->join('collaborators', 'collaborators.id', 'administrative_circular_file.acf_cirFrom')->get();
        return view('modules.letters.circularAdministrativeList', compact('collaborators', 'lists'));
    }

    function circularadministrativeToView(Request $request)
    {
        $circular = AdministrativeCircularFile::where('acf_id', $request->circular_id)->first();

        if (!$circular) {
            return back()->with('ErrorCircular', 'Circular no Encontrada');
        }
        $garden = Garden::select(
            'garden.*',
            'citys.name AS garNameCity',
            'locations.name AS garNameLocation',
            'districts.name AS garNameDistrict'
        )
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();

        $code = $circular->acf_cirNumber;
        $date = $circular->acf_cirDate;
        $to = $circular->acf_cirTo;
        $message = $circular->acf_cirBody;
        $from = Collaborator::where('id', $circular->acf_cirFrom)->first();
        $MyPDF = 'CIRCULAR_ACADEMICA_PARA_' . $circular->acf_cirTo . '.pdf';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'modules.letters.circularAdministrativePdf',
            compact(
                'code',
                'date',
                'to',
                'message',
                'from',
                'garden'
            )
        );
        return $pdf->stream();
    }

    function circularadministrativeToDelete(Request $request)
    {
        $circular = AdministrativeCircularFile::where('acf_id', $request->circularDelete)->first();
        $circularNumber = $circular->acf_cirNumber;
        if (!$circular) {
            return back()->with('ErrorCircular', 'Circular no Encontrada');
        }
        $circular->delete();
        DB::statement('alter table academic_circular_files auto_increment=1');
        return redirect()->route('circularacademic.list')->with('DeleteCircular', 'Circular N° ' . $circularNumber . ' ha sido eliminada');
    }

    function circularmemoTo()
    {
        return view('modules.letters.circularMemo');
    }

    function pdfCircularmemo(Request $request)
    {
        // dd($request->all());
        $code = $request->cirNumber;
        $date = $request->cirDate;
        $to = $request->cirTo;
        $message = $request->cirBody;
        $from = $request->cirFrom;
        $garden = Garden::select(
            'garden.*',
            'citys.name AS garNameCity',
            'locations.name AS garNameLocation',
            'districts.name AS garNameDistrict'
        )
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();
        $namefile = 'MEMORANDO_INTERNO_PARA_' . $request->cirTo . '.pdf';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'modules.letters.circularMemoPdf',
            compact(
                'code',
                'date',
                'to',
                'message',
                'from',
                'garden'
            )
        );

        $memo = new InternalMemo();
        $memo->imf_cirNumber = $request->cirNumber;
        $memo->imf_cirDate = $request->cirDate;
        $memo->imf_cirTo = Str::upper($request->cirTo);
        $memo->imf_cirBody = $request->cirBody;
        $memo->imf_cirFrom = Str::upper($request->cirFrom);
        $memo->save();

        //$pdf->setPaper("A6", "portrait");
        return $pdf->download($namefile);
    }

    function circularmemoToList()
    {
        $all = InternalMemo::all();
        return view('modules.letters.circularMemoList', compact('all'));
    }

    function circularmemoToView(Request $request)
    {
        $memointernal = InternalMemo::Where('imf_id', $request->circular_id)->first();
        if (!$memointernal) {
            return back()->with('ErrorCircular', 'Memorando no Encontrado');
        }
        $code = $memointernal->imf_cirNumber;
        $date = $memointernal->imf_cirDate;
        $to = $memointernal->imf_cirTo;
        $message = $memointernal->imf_cirBody;
        $from = $memointernal->imf_cirFrom;
        $garden = Garden::select(
            'garden.*',
            'citys.name AS garNameCity',
            'locations.name AS garNameLocation',
            'districts.name AS garNameDistrict'
        )
            ->join('citys', 'citys.id', 'garden.garCity_id')
            ->join('locations', 'locations.id', 'garden.garLocation_id')
            ->join('districts', 'districts.id', 'garden.garDistrict_id')
            ->first();
        $namefile = 'MEMORANDO_INTERNO_PARA_' . $memointernal->imf_cirTo . '.pdf';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'modules.letters.circularMemoPdf',
            compact(
                'code',
                'date',
                'to',
                'message',
                'from',
                'garden'
            )
        );
        return $pdf->stream();
    }

    function circularmemoToDelete(Request $request)
    {
        $memointernal = InternalMemo::Where('imf_id', $request->circularDelete)->first();
        $memo = $memointernal->imf_cirNumber;
        if (!$memointernal) {
            return back()->with('ErrorCircular', 'Memorando no Encontrado');
        }
        $memointernal->delete();
        DB::statement('alter table internal_memo_file auto_increment=1');
        return redirect()->route('circularmemo.list')->with('DeleteCircular', 'Circular N° ' . $memo . ' ha sido eliminada');
    }
}
