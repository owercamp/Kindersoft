<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('periods', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->bigInteger('grade_id')->unsigned(); //Llave foranea de tabla GRADOS
      $table->foreign('grade_id')->references('id')->on('grades');
      $table->date('initialDate');
      $table->date('finalDate');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('periods');
  }
}
