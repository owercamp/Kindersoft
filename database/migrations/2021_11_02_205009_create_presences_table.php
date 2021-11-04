<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresencesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('presences', function (Blueprint $table) {
      $table->bigIncrements('pre_id');
      $table->string('pre_date');
      $table->bigInteger('pre_student')->unsigned();
      $table->bigInteger('pre_course')->unsigned();
      $table->string('pre_harrival');
      $table->string('pre_tarrival');
      $table->text('pre_obsa', 500);
      $table->string('pre_hexit');
      $table->string('pre_texit');
      $table->text('obse', 500);
      $table->enum('pre_status', ['ACTIVO', 'CERRADO']);
      $table->foreign('pre_student')->references('id')->on('students');
      $table->foreign('pre_course')->references('id')->on('courses');
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
    Schema::dropIfExists('presences');
  }
}
