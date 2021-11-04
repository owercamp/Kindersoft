<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListcoursesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('listcourses', function (Blueprint $table) {
      $table->bigIncrements('listId');
      $table->bigInteger('listGrade_id')->unsigned();
      $table->foreign('listGrade_id')->references('id')->on('grades');
      $table->bigInteger('listCourse_id')->unsigned();
      $table->foreign('listCourse_id')->references('id')->on('courses');
      $table->bigInteger('listStudent_id')->unsigned();
      $table->foreign('listStudent_id')->references('id')->on('students');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('listcourses');
  }
}
