<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('autorizations', function (Blueprint $table) {
      $table->bigIncrements('auId');
      $table->bigInteger('auCourse_id')->unsigned();
      $table->foreign('auCourse_id')->references('id')->on('courses')->onDelete('cascade');
      $table->bigInteger('auStudent_id')->unsigned();
      $table->foreign('auStudent_id')->references('id')->on('students')->onDelete('cascade');
      $table->bigInteger('auAttendant_id')->unsigned();
      $table->foreign('auAttendant_id')->references('id')->on('attendants')->onDelete('cascade');
      $table->date('auDate');
      $table->text('auDescription', 600);
      $table->text('auAutorized');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('autorizations');
  }
}
