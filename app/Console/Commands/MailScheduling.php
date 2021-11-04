<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Models\Garden;
use App\Models\Customer;
use App\Models\Scheduling;
use App\Mail\MessageRemember;

class MailScheduling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:MailScheduling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de correos a clientes con agendamientos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        // return 'HANDLE DE MAIL:SCHEDULING';
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $datenext = Date('Y-m-d',strtotime(Date('Y-m-d') . ' + 1 days'));
        $schedulings = Scheduling::select('schedulings.*','customers.*')
                                ->join('customers','customers.id','schedulings.schCustomer_id')
                                ->where('schDateVisit',$datenext)
                                ->where('schResultVisit','PENDIENTE')
                                ->get();
        $garden = Garden::select('garden.*','citys.name as nameCity','locations.name as nameLocation')
                        ->join('citys','citys.id','garden.garCity_id')
                        ->join('locations','locations.id','garden.garLocation_id')
                        ->first();
        $count = 0;
        foreach ($schedulings as $scheduling) {
            $count++;
        }
        if($count > 0){
            foreach ($schedulings as $scheduling) {
                $dates = array();
                if($scheduling->cusMail != null && $scheduling->cusMail != ''){
                    array_push($dates,[
                        $scheduling->cusFirstname . ' ' . $scheduling->cusLastname,
                        $scheduling->schDayVisit,
                        $scheduling->schDateVisit,
                        $scheduling->schHourVisit,
                        $scheduling->cusChild,
                        $garden->garReasonsocial,
                        $garden->garAddress . ', ' . $garden->nameCity . ' - ' . $garden->nameLocation,
                        'TELs: ' . $garden->garPhone . ' / ' . $garden->garPhoneone
                    ]);
                    Mail::to('brayanjulianrodriguezmoreno23@gmail.com')
                        ->cc(['miscelaneatarkamy@gmail.com','brayanrockdriguez1993@hotmail.com'])
                        ->queue(new MessageRemember($dates));
                }
                // unset($dates);
            }
        }else{
            Mail::to('brayanjulianrodriguezmoreno23@gmail.com')
                        ->cc(['miscelaneatarkamy@gmail.com','brayanrockdriguez1993@hotmail.com'])
                        ->queue('SIN CORREOS PARA ENVIOS');
        }
    }
}
