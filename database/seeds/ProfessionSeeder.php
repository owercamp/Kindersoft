<?php

use Illuminate\Database\Seeder;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    public function run()
    {
    	Profession::create(['title' => 'INGENIERO DE SISTEMAS']);
    	Profession::create(['title' => 'MEDICO CIRUJANO']);
    	Profession::create(['title' => 'ABOGADO']);
    	Profession::create(['title' => 'COMUNICADOR SOCIAL']);
    	Profession::create(['title' => 'PERIODISTA']);
    	Profession::create(['title' => 'DISEÑADOR GRAFICO']);
    	Profession::create(['title' => 'ENFERMERA']);
    	Profession::create(['title' => 'INGENIERO CIVIL']);
    	Profession::create(['title' => 'EMPRESARIO INDEPENDIENTE']);
    	Profession::create(['title' => 'COMERCIANTE']);        
    }
}
