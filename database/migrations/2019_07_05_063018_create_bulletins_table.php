<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulletinsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bulletins', function (Blueprint $table) {
      $table->bigIncrements('buId');
      $table->bigInteger('buStudent_id')->unsigned();
      $table->foreign('buStudent_id')->references('id')->on('students')->onDelete('cascade');
      $table->bigInteger('buCourse_id')->unsigned();
      $table->foreign('buCourse_id')->references('id')->on('courses')->onDelete('cascade');
      $table->bigInteger('buPeriod_id')->unsigned();
      $table->foreign('buPeriod_id')->references('apId')->on('academicperiods')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('bulletins');
  }
}
