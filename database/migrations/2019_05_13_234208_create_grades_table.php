<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // Cración de tabla GRADOS
    Schema::create('grades', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->unique();
    });

    // Cración de tabla CURSOS
    Schema::create('courses', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->unique();
      $table->bigInteger('grade_id')->unsigned(); //Llave foranea de tabla GRADOS
      $table->foreign('grade_id')->references('id')->on('grades');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('courses'); //Primero se elimina la de la llave foranea
    Schema::dropIfExists('grades');
  }
}
