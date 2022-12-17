<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schedulings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('schCustomer_id')->unsigned();
      $table->foreign('schCustomer_id')->references('id')->on('customers');
      $table->date('schDateVisit');
      $table->string('schDayVisit', 10);
      $table->time('schHourVisit');
      $table->enum('schStatusVisit', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
      $table->enum('schResultVisit', ['ASISTIDO', 'INASISTIDO', 'PENDIENTE'])->default('PENDIENTE');
      $table->string('schColor', 8)->nullable();
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
    Schema::dropIfExists('schedulings');
  }
}
