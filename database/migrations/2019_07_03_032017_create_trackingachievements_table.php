<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingachievementsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('trackingachievements', function (Blueprint $table) {
      $table->bigIncrements('taId');
      $table->bigInteger('taWeektracking_id')->unsigned();
      $table->foreign('taWeektracking_id')->references('wtId')->on('weeklytrackings')->onDelete('cascade');
      $table->bigInteger('taAchievement_id')->unsigned();
      $table->foreign('taAchievement_id')->references('id')->on('achievements')->onDelete('cascade');
      $table->bigInteger('taPercentage')->default(0);
      $table->enum('taStatus', ['PENDIENTE', 'INICIADO', 'EN PROCESO', 'POR TERMINAR', 'COMPLETADO'])->default('PENDIENTE');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('trackingachievements');
  }
}
