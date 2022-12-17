<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('students', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('typedocument_id')->unsigned(); //Llave foranea de tabla DOCUMENTOS
      $table->foreign('typedocument_id')->references('id')->on('documents')->onDelete('cascade');
      $table->string('numberdocument')->unique();
      $table->string('photo');
      $table->string('firstname');
      $table->string('threename');
      $table->string('fourname');
      $table->date('birthdate');
      $table->bigInteger('yearsold'); //Calculo automatico segun fecha de nacimiento
      $table->string('address')->nullable();
      $table->bigInteger('cityhome_id')->unsigned()->nullable(); //Llave foranea de tabla CIUDADES
      $table->foreign('cityhome_id')->references('id')->on('citys')->onDelete('cascade');
      $table->bigInteger('locationhome_id')->unsigned()->nullable(); //Llave foranea de tabla LOCALIDADES
      $table->foreign('locationhome_id')->references('id')->on('locations')->onDelete('cascade');
      $table->bigInteger('dictricthome_id')->unsigned()->nullable(); //Llave foranea de tabla BARRIOS
      $table->foreign('dictricthome_id')->references('id')->on('districts')->onDelete('cascade');
      $table->bigInteger('bloodtype_id')->unsigned()->nullable(); //Llave foranea de tabla GRUPOS SANGUINEOS
      $table->foreign('bloodtype_id')->references('id')->on('bloodtypes')->onDelete('cascade');
      $table->enum('gender', ['MASCULINO', 'FEMENINO', 'INDEFINIDO']);
      $table->bigInteger('health_id')->unsigned(); //Llave foranea de tabla CENTROS DE SALUD
      $table->foreign('health_id')->references('id')->on('healths')->onDelete('cascade');
      $table->enum('additionalHealt', ['SI', 'NO'])->nullable();
      $table->string('additionalHealtDescription')->nullable();
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
    Schema::dropIfExists('students');
  }
}
