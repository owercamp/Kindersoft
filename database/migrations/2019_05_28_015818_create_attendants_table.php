<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendantsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('attendants', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('typedocument_id')->unsigned(); //Llave foranea de tabla DOCUMENTOS
      $table->foreign('typedocument_id')->references('id')->on('documents')->onDelete('cascade');
      $table->string('numberdocument')->unique();
      $table->string('firstname');
      $table->string('threename');
      $table->string('fourname');
      $table->string('address')->nullable();
      $table->bigInteger('cityhome_id')->unsigned()->nullable(); //Llave foranea de tabla CIUDADES
      $table->foreign('cityhome_id')->references('id')->on('citys')->onDelete('cascade');
      $table->bigInteger('locationhome_id')->unsigned()->nullable(); //Llave foranea de tabla LOCALIDADES
      $table->foreign('locationhome_id')->references('id')->on('locations')->onDelete('cascade');
      $table->bigInteger('dictricthome_id')->unsigned()->nullable(); //Llave foranea de tabla BARRIOS
      $table->foreign('dictricthome_id')->references('id')->on('districts')->onDelete('cascade');
      $table->string('phoneone')->nullable();
      $table->string('phonetwo')->nullable();
      $table->string('whatsapp')->nullable();
      $table->string('emailone')->nullable();
      $table->string('emailtwo')->nullable();
      $table->bigInteger('bloodtype_id')->unsigned()->nullable(); //Llave foranea de tabla GRUPOS SANGUINEOS
      $table->foreign('bloodtype_id')->references('id')->on('bloodtypes')->onDelete('cascade');
      $table->enum('gender', ['MASCULINO', 'FEMENINO', 'INDEFINIDO']);
      $table->bigInteger('profession_id')->unsigned()->nullable(); //Llave foranea de tabla PROFESIONES
      $table->foreign('profession_id')->references('id')->on('professions')->onDelete('cascade');
      $table->string('company')->nullable();
      $table->string('position')->nullable();
      $table->string('antiquity')->nullable();
      $table->string('addresscompany')->nullable();
      $table->bigInteger('citycompany_id')->unsigned()->nullable(); //Llave foranea de tabla CIUDADES
      $table->foreign('citycompany_id')->references('id')->on('citys')->onDelete('cascade');
      $table->bigInteger('locationcompany_id')->unsigned()->nullable(); //Llave foranea de tabla LOCALIDADES
      $table->foreign('locationcompany_id')->references('id')->on('locations')->onDelete('cascade');
      $table->bigInteger('dictrictcompany_id')->unsigned()->nullable(); //Llave foranea de tabla BARRIOS
      $table->foreign('dictrictcompany_id')->references('id')->on('districts')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('attendants');
  }
}
