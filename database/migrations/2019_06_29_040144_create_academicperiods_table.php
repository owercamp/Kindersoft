<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicperiodsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('academicperiods', function (Blueprint $table) {
      $table->bigIncrements('apId');
      $table->string('apNameperiod');
      $table->date('apDateInitial');
      $table->date('apDateFinal');
      $table->bigInteger('apCourse_id')->unsigned();
      $table->foreign('apCourse_id')->references('id')->on('courses');
      $table->enum('apStatus', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('academicperiods');
  }
}
