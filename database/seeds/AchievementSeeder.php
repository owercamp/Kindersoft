<?php

use Illuminate\Database\Seeder;
use App\Models\Intelligence;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kinestesica = Intelligence::where('type','KINESTESICA')->first();
        Achievement::create(['name' => 'CONTROLA FRENO INHIBITORIO', 'description' => '3', 'intelligence_id' => $kinestesica->id]);
        Achievement::create(['name' => 'CAMINA SOBRE TALÓN Y PUNTA DE PIES', 'description' => '2', 'intelligence_id' => $kinestesica->id]);
        Achievement::create(['name' => 'ENROSCA TUERCAS SOBRE TORNILLOS', 'description' => '1', 'intelligence_id' => $kinestesica->id]);

        $matematica = Intelligence::where('type','LOGICO MATEMATICA')->first();
        Achievement::create(['name' => 'UBICA ESPACIALMENTE FICHAS CORRESPONDIENTES A UN MODELO SENCILLO(LEGO)', 'description' => 'Caminadores', 'intelligence_id' => $matematica->id]);
        Achievement::create(['name' => 'IDENTIFICA VISUALMENTE LOS NúMEROS DEL 1 AL 5', 'description' => '4', 'intelligence_id' => $matematica->id]);

        $musical = Intelligence::where('type','MUSICAL')->first();
        Achievement::create(['name' => 'RECUERDA Y CANTA LA MELODíA DE LAS CANCIONES APRENDIDAS', 'description' => 'Caminadores', 'intelligence_id' => $musical->id]);
    }
}
