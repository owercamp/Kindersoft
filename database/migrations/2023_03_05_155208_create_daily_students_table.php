<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_student')->unsigned()->index('student');
            $table->bigInteger('id_daily')->index('note');
            $table->foreign('id_student')->references('id')->on('students')->onUpdate("cascade")->onDelete("cascade");
            $table->foreign('id_daily')->references('id_id')->on('info_dailies')->onUpdate("cascade")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_students');
    }
}
