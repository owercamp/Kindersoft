<?php

use Illuminate\Database\Seeder;
use App\Models\Intelligence;

class IntelligenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Intelligence::create(['type' => 'KINESTESICA', 'description' => 'Matricidad fina y gruesa']);
        Intelligence::create(['type' => 'LOGICO MATEMATICA', 'description' => 'Lógica matemática']);
        Intelligence::create(['type' => 'LINGUISTICA', 'description' => 'Lenguaje']);
        Intelligence::create(['type' => 'NATURALISTA', 'description' => 'Maturaleza y ecología']);
        Intelligence::create(['type' => 'ESPACIAL', 'description' => 'Espacio y tiempo']);
        Intelligence::create(['type' => 'INTRAPERSONAL', 'description' => 'Intrapersonal']);
        Intelligence::create(['type' => 'MUSICAL', 'description' => 'Música y danza']);
        Intelligence::create(['type' => 'INTERPERSONAL', 'description' => 'Interpersonal']);
        Intelligence::create(['type' => 'ARTE', 'description' => 'Arte']);
    }
}
