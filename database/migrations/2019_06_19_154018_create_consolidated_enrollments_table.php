<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidatedEnrollmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('consolidatedenrollments', function (Blueprint $table) {
      $table->bigIncrements('conenId');
      $table->bigInteger('conenStudent_id')->unsigned();
      $table->foreign('conenStudent_id')->references('id')->on('students');
      $table->enum('conenStatus', ['PENDIENTE', 'COMPLETADO'])->default('PENDIENTE');
      $table->text('conenRequirements');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('consolidatedenrollments');
  }
}
