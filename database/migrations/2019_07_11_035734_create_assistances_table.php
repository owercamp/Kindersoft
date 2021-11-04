<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistancesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('assistances', function (Blueprint $table) {
      $table->bigIncrements('assId');
      $table->bigInteger('assCourse_id')->unsigned();
      $table->foreign('assCourse_id')->references('id')->on('courses')->onDelete('cascade');
      $table->date('assDate');
      $table->text('assPresents');
      $table->text('assAbsents');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('assistances');
  }
}
