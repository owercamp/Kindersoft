<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdToConsolideAchievements extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('consolide_achievements', function (Blueprint $table) {
      $table->bigInteger('course_id')->unsigned(); //Llave foranea de tabla CURSOS
      $table->foreign('course_id')->references('id')->on('courses');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('consolide_achievements', function (Blueprint $table) {
      $table->dropColumn('course_id');
    });
  }
}
