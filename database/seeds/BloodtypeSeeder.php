<?php

use Illuminate\Database\Seeder;
use App\Models\Bloodtype;

class BloodtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BLoodtype::create(["group" => "A", "type" => "POSITIVO"]);
        BLoodtype::create(["group" => "A", "type" => "NEGATIVO"]);
        BLoodtype::create(["group" => "B", "type" => "POSITIVO"]);
        BLoodtype::create(["group" => "B", "type" => "NEGATIVO"]);
        BLoodtype::create(["group" => "AB", "type" => "POSITIVO"]);
        BLoodtype::create(["group" => "AB", "type" => "NEGATIVO"]);
        BLoodtype::create(["group" => "O", "type" => "POSITIVO"]);
        BLoodtype::create(["group" => "O", "type" => "NEGATIVO"]);
    }
}
