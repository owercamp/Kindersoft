<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicCircularFilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('academic_circular_files', function (Blueprint $table) {
      $table->bigIncrements('acf_id');
      $table->date('acf_cirDate');
      $table->string('acf_cirNumber', 6);
      $table->string('acf_cirTo', 50);
      $table->bigInteger('acf_cirBody_id')->unsigned();
      $table->text('acf_cirBody');
      $table->bigInteger('acf_cirFrom')->unsigned();
      $table->foreign('acf_cirBody_id')->references('bcId')->on('bodycircular');
      $table->foreign('acf_cirFrom')->references('id')->on('collaborators');
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
    Schema::dropIfExists('academic_circular_files');
  }
}
