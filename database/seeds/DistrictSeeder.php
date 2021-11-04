<?php

use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\Location;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usaquen = Location::where('name','USAQUEN')->first();
        District::create([ "name" => "SANTA BARBARA ORIENTAL", "location_id" => $usaquen->id ]);
        District::create([ "name" => "SANTA BARBARA OCCIDENTAL", "location_id" => $usaquen->id ]);
        District::create([ "name" => "UNICENTRO", "location_id" => $usaquen->id ]);
        District::create([ "name" => "TORCA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "EL REDIL", "location_id" => $usaquen->id ]);
        District::create([ "name" => "LA CITA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "ALTABLANCA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "BARRANCAS", "location_id" => $usaquen->id ]);
        District::create([ "name" => "VILLA MAGDALA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "CEDRITOS", "location_id" => $usaquen->id ]);
        District::create([ "name" => "BELMIRA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "LISBOA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "CEDRO GOLF", "location_id" => $usaquen->id ]);
        District::create([ "name" => "SANTA ANA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "BELLA SUIZA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "LA CALLEJA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "BOSQUE MEDINA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "LA CAROLINA", "location_id" => $usaquen->id ]);
        District::create([ "name" => "MULTICENTRO", "location_id" => $usaquen->id ]);

        $chapinero = Location::where('name','CHAPINERO')->first();
        District::create([ "name" => "CHICÓ", "location_id" => $chapinero->id ]);
    }
}
