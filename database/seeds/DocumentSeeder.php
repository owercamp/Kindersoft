<?php

use Illuminate\Database\Seeder;

use App\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::create(['type' => 'CEDULA DE CIUDADANIA']);
        Document::create(['type' => 'TARJETA DE IDENTIDAD']);
        Document::create(['type' => 'CEDULA DE EXTRANJERIA']);
        Document::create(['type' => 'PASAPORTE']);
        Document::create(['type' => 'NIT']);
    }
}
