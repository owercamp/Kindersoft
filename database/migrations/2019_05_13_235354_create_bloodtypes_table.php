<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloodtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloodtypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('group',['A','B','AB','O','NO REPORTADA']);
            $table->enum('type',['POSITIVO','NEGATIVO'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloodtypes');
    }
}
