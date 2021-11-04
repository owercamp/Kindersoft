<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoursweekTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('hoursweek', function (Blueprint $table) {
      $table->bigIncrements('hwId');
      $table->date('hwDate');
      $table->time('hwHourInitial');
      $table->time('hwHourFinal');
      $table->bigInteger('hwDay');
      $table->bigInteger('hwActivityClass_id')->unsigned();
      $table->foreign('hwActivityClass_id')->references('acId')->on('activityclass');
      $table->bigInteger('hwActivitySpace_id')->unsigned();
      $table->foreign('hwActivitySpace_id')->references('asId')->on('activityspaces');
      $table->bigInteger('hwCollaborator_id')->unsigned();
      $table->foreign('hwCollaborator_id')->references('id')->on('collaborators');
      $table->bigInteger('hwCourse_id')->unsigned();
      $table->foreign('hwCourse_id')->references('id')->on('courses');
      $table->enum('hwStatus', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('hoursweek');
  }
}
