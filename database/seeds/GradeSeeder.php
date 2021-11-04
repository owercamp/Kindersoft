<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Grade::create(['name' => 'CAMINADORES']);
    	Grade::create(['name' => 'PARVULOS']);
    	Grade::create(['name' => 'PRE JARDIN']);
    	Grade::create(['name' => 'JARDIN']);
    }
}
