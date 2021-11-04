<?php

use Illuminate\Database\Seeder;
use App\Models\Health;

class HealthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Health::create(['entity' => 'COMPENSAR', 'type' => 'PREPAGADA']);
        Health::create(['entity' => 'COMPENSAR', 'type' => 'EPS']);
        Health::create(['entity' => 'SANITAS', 'type' => 'EPS']);
        Health::create(['entity' => 'SURA', 'type' => 'PREPAGADA']);
        Health::create(['entity' => 'SURA', 'type' => 'EPS']);
        Health::create(['entity' => 'COLMEDICA', 'type' => 'PREPAGADA']);
        Health::create(['entity' => 'ALIANZASALUD', 'type' => 'EPS']);
        Health::create(['entity' => 'FAMISANAR', 'type' => 'EPS']);
        Health::create(['entity' => 'COOMEVA', 'type' => 'EPS']);
        Health::create(['entity' => 'COOMEVA', 'type' => 'PREPAGADA']);
    }
}
