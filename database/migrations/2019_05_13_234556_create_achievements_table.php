<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // Creación de tabla INTELIGENCIAS
    Schema::create('intelligences', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('type')->unique();
      $table->string('description');
      $table->timestamps();
    });

    // Creación de tabla LOGROS
    Schema::create('achievements', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->unique();
      $table->string('description');
      $table->bigInteger('intelligence_id')->unsigned(); //Llave foranea de tabla INTELIGENCIAS
      $table->foreign('intelligence_id')->references('id')->on('intelligences');
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
    Schema::dropIfExists('achievements'); //Primero se elimina la de la llave foranea
    Schema::dropIfExists('intelligences');
  }
}
