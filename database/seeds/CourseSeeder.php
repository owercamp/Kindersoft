<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$caminadores = Grade::where('name','CAMINADORES')->first();
    	Course::create(['name' => 'CAMINADORES A', 'grade_id' => $caminadores->id]);
    	Course::create(['name' => 'CAMINADORES B', 'grade_id' => $caminadores->id]);
    	$parvulos = Grade::where('name','PARVULOS')->first();
    	Course::create(['name' => 'PARVULOS A', 'grade_id' => $parvulos->id]);
    	Course::create(['name' => 'PARVULOS B', 'grade_id' => $parvulos->id]);
    	$prejardin = Grade::where('name','PRE JARDIN')->first();
    	Course::create(['name' => 'PRE JARDIN A', 'grade_id' => $prejardin->id]);
    	Course::create(['name' => 'PRE JARDIN B', 'grade_id' => $prejardin->id]);
    	$jardin = Grade::where('name','JARDIN')->first();
    	Course::create(['name' => 'JARDIN A', 'grade_id' => $jardin->id]);
    	Course::create(['name' => 'JARDIN B', 'grade_id' => $jardin->id]);
    }
}
