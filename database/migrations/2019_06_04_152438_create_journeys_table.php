<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneysTable extends Migration
{
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jouJourney');
            $table->string('jouDays');
            $table->time('jouHourEntry');
            $table->time('jouHourExit');
            $table->float('jouValue',9,2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('journeys');
    }
}
