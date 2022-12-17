<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('admConcept')->unique();
            $table->float('admValue',9,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}
