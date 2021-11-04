<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Egress;

class VoucheregressExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // use Exportable;
    protected $dateInitial; 
    protected $dateFinal; 

    function __construct($dateInitial,$dateFinal){
        $this->dateInitial = $dateInitial;
        $this->dateFinal = $dateFinal;
    }

    public function view(): View
    {
        return view('modules.vouchers.egressExcel', [
        	'vouchers' => Egress::select(
	            	'voucheregress.*',
	                'providers.namecompany',
	                'providers.numberdocument',
	                'providers.numbercheck'
	            )
	            ->join('providers','providers.id','voucheregress.vegProvider_id')
	            ->whereBetween('vegDate',[$this->dateInitial,$this->dateFinal])
	            ->orderBy('providers.namecompany','asc')
	            ->get()
        ]);
    }
}
