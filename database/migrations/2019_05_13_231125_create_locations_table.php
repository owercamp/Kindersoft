<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('locations', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->bigInteger('city_id')->unsigned(); //Llave foranea de tabla ciudades
      $table->foreign('city_id')->references('id')->on('citys')->onDelete('cascade');
      //$table->dropForeign('city_id_foreign');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('locations');
  }
}
