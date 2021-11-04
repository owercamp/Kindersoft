<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesconsolidatedTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coursesconsolidated', function (Blueprint $table) {
      $table->bigIncrements('ccId');
      $table->bigInteger('ccGrade_id')->unsigned();
      $table->foreign('ccGrade_id')->references('id')->on('grades')->onDelete('cascade');
      $table->bigInteger('ccCourse_id')->unsigned();
      $table->foreign('ccCourse_id')->references('id')->on('courses')->onDelete('cascade');
      $table->bigInteger('ccCollaborator_id')->unsigned();
      $table->foreign('ccCollaborator_id')->references('id')->on('collaborators')->onDelete('cascade');
      $table->date('ccDateInitial');
      $table->date('ccDateFinal');
      $table->enum('ccStatus', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coursesconsolidated');
  }
}
