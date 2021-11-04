<?php

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create(["name" => "BOGOTÁ"]);
        City::create(["name" => "MEDELLIN"]);
        City::create(["name" => "CALI"]);
        City::create(["name" => "BARRANQUILLA"]);
        City::create(["name" => "BUCARAMANGA"]);
        City::create(["name" => "VILLAVICENCIO"]);
        City::create(["name" => "FLORENCIA"]);
        City::create(["name" => "IBAGUÉ"]);
        City::create(["name" => "NEIVA"]);
        City::create(["name" => "POPAYÁN"]);
        City::create(["name" => "CHOCO"]);        
    }
}
