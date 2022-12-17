<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChronologicalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('chronologicals', function (Blueprint $table) {
      $table->bigIncrements('chId');
      $table->bigInteger('chAcademicperiod_id')->unsigned();
      $table->foreign('chAcademicperiod_id')->references('apId')->on('academicperiods')->onDelete('cascade');
      $table->string('chRangeWeek');
      $table->string('chNumberWeek', 2);
      $table->bigInteger('chIntelligence_id')->unsigned();
      $table->foreign('chIntelligence_id')->references('id')->on('intelligences')->onDelete('cascade');
      $table->bigInteger('chCollaborator_id')->unsigned();
      $table->foreign('chCollaborator_id')->references('id')->on('collaborators')->onDelete('cascade');
      $table->string('chDescription', 1000);
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
    Schema::dropIfExists('chronologicals');
  }
}
