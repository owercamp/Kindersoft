<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "id" => "1024537577",
            "firstname" => "JULIAN",
            "lastname" => "RODRIGUEZ",
            "password" => bcrypt('bjrodriguemo')
        ])->assignRole('ADMINISTRADOR SISTEMA');

        User::create([
            "id" => "80503717",
            "firstname" => "JAVIER",
            "lastname" => "VARGAS PRIETO",
            "password" => bcrypt('javapri')
        ])->assignRole('ADMINISTRADOR SISTEMA');

        /*for ($i=1; $i <= 50; $i++) { 
            User::create([
                "id" => rand(9999999, 99999999),
                "firstname" => Str::random(8),
                "lastname" => Str::random(8),
                "password" => bcrypt(str_random(10)),
            ])->assignRole($this->randomRole());
        }*/


        /*User::create([
            "id" => "10298637",
            "firstname" => "MARTHA",
            "lastname" => "GONZALEZ",
            "password" => bcrypt('martha12345')
        ])->assignRole($this->randomRole());

        User::create([
            "id" => "273876259",
            "firstname" => "SANDRA",
            "lastname" => "HUERTAS",
            "password" => bcrypt('sandra12345')
        ])->assignRole($this->randomRole());

        User::create([
            "id" => "1892763562",
            "firstname" => "PEDRO",
            "lastname" => "SILVA",
            "password" => bcrypt('pedro12345')
        ])->assignRole($this->randomRole());

        User::create([
            "id" => "1982763789",
            "firstname" => "PABLO",
            "lastname" => "QUINTANA",
            "password" => bcrypt('pablo12345')
        ])->assignRole($this->randomRole());*/

    }

    function randomRole($number = 0){
        if($number = 0){
            mt_rand(1,5);
        }
        switch ($number) {
            case 1:
                return "ADMIN-SYSTEM";
                break;
            case 2:
                return "ADMIN-ORG";
                break;
            case 3:
                return "ADMIN-COM";
                break;
            case 4:
                return "ADMIN-ACA";
                break;
            case 5:
                return "ADMIN-LOG";
                break;
        }
    }
}