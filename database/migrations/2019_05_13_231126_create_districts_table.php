<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('districts', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->bigInteger('location_id')->unsigned(); //Llave foranea de tabla localidades
      $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
      //$table->dropForeign('location_id_foreign');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('districts');
  }
}
