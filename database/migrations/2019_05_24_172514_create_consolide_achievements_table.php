<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolideAchievementsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('consolide_achievements', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('achievement_id')->unsigned(); //Llave foranea de tabla LOGROS
      $table->foreign('achievement_id')->references('id')->on('achievements');
      $table->bigInteger('period_id')->unsigned(); //Llave foranea de tabla PERIODOS
      $table->foreign('period_id')->references('id')->on('periods');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('consolide_achievements');
  }
}
