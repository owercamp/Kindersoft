<?php

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\City;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bogota = City::where('name','BOGOTÁ')->first();
        Location::create([ "name" => "USAQUEN", "city_id" => $bogota->id ]);
        Location::create([ "name" => "CHAPINERO", "city_id" => $bogota->id ]);
        Location::create([ "name" => "SUBA", "city_id" => $bogota->id ]);
        Location::create([ "name" => "KENNEDY", "city_id" => $bogota->id ]);
        Location::create([ "name" => "ENGATIVA", "city_id" => $bogota->id ]);
        Location::create([ "name" => "SAN CRISTOBAL SUR", "city_id" => $bogota->id ]);
        Location::create([ "name" => "CIUDAD BOLIVAR", "city_id" => $bogota->id ]);
        Location::create([ "name" => "SUMAPAZ", "city_id" => $bogota->id ]);
        Location::create([ "name" => "LOS MARTIRES", "city_id" => $bogota->id ]);
        Location::create([ "name" => "USME", "city_id" => $bogota->id ]);
        Location::create([ "name" => "SANTAFE", "city_id" => $bogota->id ]);
        Location::create([ "name" => "FONTIBON", "city_id" => $bogota->id ]);
    }
}
