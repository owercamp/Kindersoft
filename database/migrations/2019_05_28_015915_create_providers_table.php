<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('providers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('typedocument_id')->unsigned(); //Llave foranea de tabla DOCUMENTOS
      $table->foreign('typedocument_id')->references('id')->on('documents');
      $table->string('numberdocument')->unique();
      $table->string('numbercheck')->nullable(); //Solo se llena si es tipo de documento NIT
      $table->string('namecompany');
      $table->string('address')->nullable();
      $table->bigInteger('cityhome_id')->unsigned()->nullable(); //Llave foranea de tabla CIUDADES
      $table->foreign('cityhome_id')->references('id')->on('citys');
      $table->bigInteger('locationhome_id')->unsigned()->nullable(); //Llave foranea de tabla LOCALIDADES
      $table->foreign('locationhome_id')->references('id')->on('locations');
      $table->bigInteger('dictricthome_id')->unsigned()->nullable(); //Llave foranea de tabla BARRIOS
      $table->foreign('dictricthome_id')->references('id')->on('districts');
      $table->string('phoneone')->nullable();
      $table->string('phonetwo')->nullable();
      $table->string('whatsapp')->nullable();
      $table->string('emailone')->nullable();
      $table->string('emailtwo')->nullable();
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
    Schema::dropIfExists('providers');
  }
}
