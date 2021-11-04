<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklytrackingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('weeklytrackings', function (Blueprint $table) {
      $table->bigIncrements('wtId');
      $table->bigInteger('wtChronological_id')->unsigned();
      $table->foreign('wtChronological_id')->references('chId')->on('chronologicals')->onDelete('cascade');
      $table->bigInteger('wtStudent_id')->unsigned();
      $table->foreign('wtStudent_id')->references('id')->on('students')->onDelete('cascade');
      $table->bigInteger('wtIntelligence_id')->unsigned();
      $table->foreign('wtIntelligence_id')->references('id')->on('intelligences')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('weeklytrackings');
  }
}
