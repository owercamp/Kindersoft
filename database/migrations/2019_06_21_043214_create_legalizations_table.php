<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalizationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('legalizations', function (Blueprint $table) {
      $table->bigIncrements('legId');
      $table->bigInteger('legStudent_id')->unsigned();
      $table->foreign('legStudent_id')->references('id')->on('students');
      $table->bigInteger('legAttendantfather_id')->unsigned();
      $table->foreign('legAttendantfather_id')->references('id')->on('attendants');
      $table->bigInteger('legAttendantmother_id')->unsigned();
      $table->foreign('legAttendantmother_id')->references('id')->on('attendants');
      $table->bigInteger('legGrade_id')->unsigned();
      $table->foreign('legGrade_id')->references('id')->on('grades');
      $table->bigInteger('legCourse_id')->unsigned();
      $table->foreign('legCourse_id')->references('id')->on('courses');
      $table->date('legDateInitial');
      $table->date('legDateFinal');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('legalizations');
  }
}
